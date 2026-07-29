<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    // Cart စာမျက်နှာ ပြသခြင်း
    public function index()
    {
        $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);

        $subtotal = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        return view('cart', compact('cart', 'subtotal')); // မိမိ view path အတိုင်း ညှိပါ
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);

        $size = $request->input('size', null);
        $color = $request->input('color', null);
        $quantity = (int) $request->input('quantity', 1);

        // Cart Key
        $cartKey = $id . ($size ? '-' . $size : '') . ($color ? '-' . $color : '');

        // Current Cart ထဲရှိနှင့်ပြီးသား အရေအတွက်ကို ရယူခြင်း
        $currentCartQty = isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0;
        $newTotalQty = $currentCartQty + $quantity;

        // 🔴 1. Cart ထဲမှာ ရောက်နေပြီးသား အရေအတွက်က Maximum Stock အထိ ဖြစ်နေပြီးသားဆိုလျှင်
        if ($currentCartQty >= $product->stock) {
            return redirect()->route('dashboard')->with('error', "Maximum stock capacity reached ({$product->stock} items already in cart)!");
        }

        // 🔴 2. ထပ်ပေါင်းမယ့် အရေအတွက်က Stock ထက် ကျော်လွန်သွားပါက Maximum Stock အထိပဲ သတ်မှတ်ပေးမည်
        if ($newTotalQty > $product->stock) {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->stock, // Max Stock အထိပဲ ထည့်ပေးမည်
                'image' => $product->image,
                'size' => $size,
                'color' => $color,
                'stock' => $product->stock
            ];

            Cookie::queue('shopping_cart', json_encode($cart), 43200);

            return redirect()->route('dashboard')->with('warning', "Cart updated to maximum available stock ({$product->stock} items)!");
        }

        // 🟢 3. Stock မကျော်သေးပါက ပုံမှန်အတိုင်း ပေါင်းပေးမည်
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = $newTotalQty;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
                'size' => $size,
                'color' => $color,
                'stock' => $product->stock
            ];
        }

        Cookie::queue('shopping_cart', json_encode($cart), 43200);

        return redirect()->route('dashboard')->with('success', 'Product added to cart!');
    }

    // Cart ထဲမှ အရေအတွက် ပြင်ခြင်း
    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);
            if (isset($cart[$request->id])) {
                $cart[$request->id]['quantity'] = (int) $request->quantity;
                Cookie::queue('shopping_cart', json_encode($cart), 43200);
            }
        }
        return response()->json(['status' => 'success']);
    }

    // Cart ထဲမှ Item ဖျက်ခြင်း
    public function removeCart(Request $request)
    {
        if ($request->id) {
            $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                Cookie::queue('shopping_cart', json_encode($cart), 43200);
            }
        }
        return response()->json(['status' => 'success']);
    }

    public function clearCart()
    {
        Cookie::queue(Cookie::forget('shopping_cart'));
        return response()->json(['status' => 'success']);
    }
}