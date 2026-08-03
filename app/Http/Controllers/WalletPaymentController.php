<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Product;
use App\Models\ProductColor; // 💡 ProductColor Model ကို import လုပ်ရန် လိုအပ်ပါက ထည့်ပါ
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class WalletPaymentController extends Controller
{
    // ၁။ QR Scan ဖတ်ပြီးရင် ပွင့်လာမည့် 6-Digit Password ရိုက်သည့် Form
    public function showPaymentPage($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        $user = auth()->user();

        $wallet = Wallet::where('user_id', $user->id)->first();

        // အော်ဒါက Paid ဖြစ်ပြီးသားဆိုလျှင် ပြန်ပေးမကြည့်ပါ
        if ($order->status === 'paid') {
            return response('<div style="text-align:center; padding:50px;"><h2>⚠️ This order has already been paid.</h2></div>');
        }

        return view('wallet.pay', compact('order', 'wallet'));
    }

    // ၂။ Password စစ်ဆေးပြီး Admin (2%) + Vendor (98%) ငွေခွဲပေးမည့် Logic
    public function processPayment(Request $request, $orderId)
    {
        $request->validate([
            'wallet_password' => 'required|digits:6',
        ]);

        $order = Order::with('items')->findOrFail($orderId);
        $user = auth()->user();

        // User ရဲ့ Wallet ကို ရှိပြီးသားအတိုင်း ရှာမည်
        $wallet = Wallet::where('user_id', $user->id)->first();

        if (!$wallet) {
            return back()->with('error', 'Wallet not found.');
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

                // 💡 Product Stock နှင့် Product Color Stock လျှော့ချခြင်း
                if ($item->product_id) {
                    // အကယ်၍ order item ထဲမှာ color ပါလာခဲ့လျှင် product_colors ထဲက stock ကို နှုတ်မည်
                    if (!empty($item->color)) {
                        ProductColor::where('product_id', $item->product_id)
                            ->where(function ($query) use ($item) {
                                $query->where('color', $item->color)
                                    ->orWhere('color_name', $item->color);
                            })
                            ->decrement('stock', $item->quantity);
                    }

                    // မူလ Product table ထဲက general stock ကိုပါ တွဲလျော့လိုပါက ဤနေရာတွင် ထည့်နိုင်သည်
                    Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
                }
            }

            // Order Status ကို Paid ပြောင်းမည်
            $order->update(['status' => 'paid']);

            // Shopping Cart Cookie ကို ရှင်းထုတ်လိုပါက ဤနေရာတွင် ဖွင့်နိုင်သည်
            // Cookie::queue(Cookie::forget('shopping_cart'));
        });

        return view('wallet.success', compact('order'));
    }
}
