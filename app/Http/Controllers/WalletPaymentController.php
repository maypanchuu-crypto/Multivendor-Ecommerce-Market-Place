<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class WalletPaymentController extends Controller
{
    // ၁။ QR Scan ဖတ်ပြီးရင် ပွင့်လာမည့် 6-Digit Password ရိုက်သည့် Form
    public function showPaymentPage($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);

        // အော်ဒါက Paid ဖြစ်ပြီးသားဆိုလျှင် ပြန်ပေးမကြည့်ပါ
        if ($order->status === 'paid') {
            return response('<div style="text-align:center; padding:50px;"><h2>⚠️ This order has already been paid.</h2></div>');
        }

        return view('wallet.pay', compact('order'));
    }

    // ၂။ Password စစ်ဆေးပြီး Admin (2%) + Vendor (98%) ငွေခွဲပေးမည့် Logic
    public function processPayment(Request $request, $orderId)
    {
        $request->validate([
            'wallet_password' => 'required|digits:6',
        ]);

        $order = Order::with('items')->findOrFail($orderId);
        $user = auth()->user();

        // 💡 User မှာ Wallet မရှိသေးရင် အလိုအလျောက် Create လုပ်ပေးပြီး Default Password 123456 ပေးမည်
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'balance' => 1000000, // စမ်းသပ်ရန် Balance မူလ ပေးထားခြင်း
                'wallet_password' => Hash::make('123456') // 💡 Default Password: 123456
            ]
        );

        // Password မရှိသေးပါကလည်း Default 123456 သတ်မှတ်ပေးမည်
        if (empty($wallet->wallet_password)) {
            $wallet->update(['wallet_password' => Hash::make('123456')]);
        }

        // Password စစ်ဆေးခြင်း
        if (!Hash::check($request->wallet_password, $wallet->wallet_password)) {
            return back()->with('error', 'Wallet Password (PIN) is incorrect.');
        }

        // Balance စစ်ဆေးခြင်း
        if ($wallet->balance < $order->total_amount) {
            return back()->with('error', 'Insufficient balance in your wallet.');
        }

        // 💡 Transaction ဖြင့် Admin (2%) နှင့် Vendor (98%) သို့ ငွေခွဲဝေပေးခြင်း
        DB::transaction(function () use ($wallet, $order) {

            // Customer Wallet မှ ပိုက်ဆံ နှုတ်မည်
            $wallet->decrement('balance', $order->total_amount);

            $admin = User::where('role', 'admin')->first();

            foreach ($order->items as $item) {
                $itemTotal = $item->price * $item->quantity;

                $adminCommission = $itemTotal * 0.02;          // 2% Admin Commission
                $vendorAmount = $itemTotal - $adminCommission; // 98% Vendor Share

                // Admin Wallet ထဲ ငွေထည့်ပေးခြင်း
                if ($admin) {
                    $adminWallet = Wallet::firstOrCreate(['user_id' => $admin->id]);
                    $adminWallet->increment('balance', $adminCommission);
                }

                // Vendor Wallet ထဲ ငွေထည့်ပေးခြင်း
                if ($item->vendor_id) {
                    $vendorWallet = Wallet::firstOrCreate(['user_id' => $item->vendor_id]);
                    $vendorWallet->increment('balance', $vendorAmount);
                }

                if ($item->product_id) {
                    Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
                }
            }

            // Order Status ကို Paid ပြောင်းမည်
            $order->update(['status' => 'paid']);

            // Shopping Cart Cookie ကို ရှင်းထုတ်မည်
            // Cookie::queue(Cookie::forget('shopping_cart'));
        });

        return view('wallet.success', compact('order'));
    }
}