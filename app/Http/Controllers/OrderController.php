<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);

        $total = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        return view('checkout', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);

        if (empty($cart)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please add items to the cart before placing an order.'
            ], 400);
        }

        $total = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        // 💡 DB Transaction သုံးပြီး Order နှင့် OrderItems များကို အတူတူ Save မည်
        $order = DB::transaction(function () use ($request, $cart, $total) {

            // ၁။ Order Create/Update လုပ်မည်
            $order = Order::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'status' => 'pending',
                ],
                [
                    'total_amount' => $total,
                    'customer_name' => $request->input('customer_name', auth()->user()->name),
                    'customer_phone' => $request->phone,
                    'shipping_address' => $request->address,
                ]
            );

            // 💡 ၂။ ယခင်က အဟောင်းရှိခဲ့ပါက Duplicate မဖြစ်စေရန် ထိန်းသိမ်းခြင်း
            $order->items()->delete();

            // 💡 ၃။ Cart ထဲက Data များကို OrderItem ထဲသို့ Loop ပတ်၍ ထည့်သွင်းခြင်း
            foreach ($cart as $key => $item) {

                // Product ရှာ၍ vendor_id ယူရန်
                $productId = $item['product_id'] ?? $key;
                $product = Product::find($productId);

                if ($product) {
                    $itemTotal = $item['price'] * $item['quantity'];
                    $adminCommission = $itemTotal * 0.02; // 2% Admin Commission
                    $vendorAmount = $itemTotal - $adminCommission; // 98% Vendor Share

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'vendor_id' => $product->user_id, // Product ပိုင်ရှင် Vendor ID
                        'quantity' => $item['quantity'],
                        'color' => $item['color'] ?? null,
                        'size' => $item['size'] ?? null,
                        'price' => $item['price'],
                        'admin_commission' => $adminCommission,
                        'vendor_amount' => $vendorAmount,
                    ]);
                }
            }

            return $order;
        });

        // QR Code URL ထုတ်ပေးခြင်း
        $paymentUrl = url('/wallet/pay/' . $order->id);
        $qrCode = QrCode::size(200)->generate($paymentUrl);

        return response()->json([
            'status' => 'success',
            'order_id' => $order->id,
            'qr_code' => 'data:image/svg+xml;base64,' . base64_encode($qrCode)
        ]);
    }

    public function confirmPayment($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response('<h3>Order not found!</h3>', 404);
        }

        if ($order->status !== 'paid') {
            $order->update(['status' => 'paid']);
            Cookie::queue(Cookie::forget('shopping_cart'));
        }

        return response('
        <div style="text-align: center; padding: 50px; font-family: sans-serif;">
            <h2 style="color: green;">🎉 Payment successful.</h2>
            <p>Order has been paid successfully.</p>
        </div>
        ');
    }

    public function history()
    {
        // လက်ရှိ Login ဝင်ထားသော customer ၏ order များကို အသစ်ဆုံးမှ အဟောင်းသို့ စီ၍ ယူမည်
        $orderItems = OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->with(['order', 'product']) // Order နှင့် Product အချက်အလက်များပါ တွဲယူရန်
            ->latest()
            ->paginate(10);

        return view('order-history', compact('orderItems'));
    }
}