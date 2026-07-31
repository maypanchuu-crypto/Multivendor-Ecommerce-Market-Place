<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    //
    public function index()
    {
        $trendingProductIds = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(6)
            ->pluck('product_id');

        // 💡 relationships များကို with() ဖြင့် တွဲခေါ်ပါ
        $relations = ['images', 'colorVariants', 'vendor'];

        if ($trendingProductIds->isEmpty()) {
            $trendingProducts = Product::with($relations)->latest()->take(6)->get();
        } else {
            $trendingProducts = Product::with($relations)
                ->whereIn('id', $trendingProductIds)
                ->orderByRaw("FIELD(id, " . implode(',', $trendingProductIds->toArray()) . ")")
                ->get();
        }

        $moreProducts = Product::with($relations)->inRandomOrder()->get();

        $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);
        $cartCount = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['quantity'] ?? 0);
        }, 0);

        return view('dashboard', compact('trendingProducts', 'moreProducts', 'cartCount'));
    }

    public function show($id)
    {
        $product = Product::with(['vendor', 'images'])->findOrFail($id);

        return view('product-detail', compact('product'));
    }
}
