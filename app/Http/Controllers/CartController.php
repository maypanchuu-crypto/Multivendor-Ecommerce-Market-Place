<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{

    public function index()
    {
        $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);

        $subtotal = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        return view('cart', compact('cart', 'subtotal'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::with(['images', 'colorVariants'])->findOrFail($id);
        $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);

        $size = $request->input('size', null);
        $color = $request->input('color', null);
        $quantity = (int) $request->input('quantity', 1);

        // 💡 အရောင်နှင့် သက်ဆိုင်သော ပုံနှင့် Stock ကို ရှာဖွေခြင်း
        $selectedImage = null;
        $availableStock = $product->stock; // default fallback to main product stock

        if ($color) {
            $colorVariant = $product->colorVariants->first(function ($variant) use ($color) {
                return strtolower(trim($variant->color_name ?? $variant->color ?? '')) === strtolower(trim($color));
            });

            if ($colorVariant) {
                if ($colorVariant->image_path) {
                    $selectedImage = $colorVariant->image_path;
                }
                // အရောင်အတွက် သီးသန့် stock ရှိပါက ယင်းကို သုံးမည်
                if (isset($colorVariant->stock)) {
                    $availableStock = $colorVariant->stock;
                }
            }
        }

        if (!$selectedImage && $product->images->isNotEmpty()) {
            $selectedImage = $product->images->first()->image_path;
        }

        // Cart Key
        $cartKey = $id . ($size ? '-' . $size : '') . ($color ? '-' . $color : '');

        $currentCartQty = isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0;
        $newTotalQty = $currentCartQty + $quantity;

        if ($currentCartQty >= $availableStock) {
            return redirect()->route('dashboard')->with('error', "Maximum stock capacity reached ({$availableStock} items already in cart)!");
        }

        if ($newTotalQty > $availableStock) {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $availableStock,
                'image' => $selectedImage,
                'size' => $size,
                'color' => $color,
                'stock' => $availableStock // 💡 အရောင်အလိုက် stock ကို သိမ်းမည်
            ];

            Cookie::queue('shopping_cart', json_encode($cart), 43200);
            return redirect()->route('dashboard')->with('warning', "Cart updated to maximum available stock ({$availableStock} items)!");
        }

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = $newTotalQty;
            $cart[$cartKey]['image'] = $selectedImage;
            $cart[$cartKey]['stock'] = $availableStock;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $selectedImage,
                'size' => $size,
                'color' => $color,
                'stock' => $availableStock // 💡 အရောင်အလိုက် stock ကို သိမ်းမည်
            ];
        }

        Cookie::queue('shopping_cart', json_encode($cart), 43200);

        return redirect()->route('dashboard')->with('success', 'Product added to cart!');
    }


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