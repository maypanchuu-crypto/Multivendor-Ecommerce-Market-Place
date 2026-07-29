<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\OrderItem;

class VendorDashboardController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Auth::user();

        $allProducts = Product::where('user_id', $vendor->id)->get();
        $totalProducts = $allProducts->count();

        // 💡 ဒီနေ့ (၁ ရက်စာ) Paid ဖြစ်ပြီးသား Order Items များကို ယူမည်
        $todayPaidItems = OrderItem::where('vendor_id', $vendor->id)
            ->whereHas('order', function ($q) {
                $q->where('status', 'paid')
                    ->whereDate('created_at', \Carbon\Carbon::today()); // ဒီနေ့ရက်စွဲ စစ်ထုတ်ခြင်း
            })
            ->get();

        // 💡 1. ဒီနေ့ paid ဖြစ်ပြီးသား အော်ဒါအရေအတွက် (သို့မဟုတ် Item အရေအတွက်)
        $totalOrders = $todayPaidItems->count();
        // မူကွဲ - Item အရေအတွက် စုစုပေါင်းယူချင်ပါက: $todayPaidItems->sum('quantity');

        // 💡 2. ဒီနေ့ paid ဖြစ်ပြီးသား စုစုပေါင်း ဝင်ငွေ (98% Net Earnings)
        $totalEarnings = $todayPaidItems->sum(function ($item) {
            return $item->vendor_amount > 0
                ? $item->vendor_amount
                : (($item->price * $item->quantity) * 0.98);
        });

        $query = Product::where('user_id', $vendor->id);

        $stock_status = $request->input('stock_status');

        if ($stock_status != '') {
            if ($stock_status === 'in_stock') {
                $query->where('stock', '>', 5);
            } elseif ($stock_status === 'low_stock') {
                $query->where('stock', '>', 0)->where('stock', '<=', 5);
            } elseif ($stock_status === 'out_of_stock') {
                $query->where('stock', '=', 0);
            }
        }

        $products = $query->latest()->get();

        return view('vendor.dashboard', compact('vendor', 'totalProducts', 'totalOrders', 'totalEarnings', 'products', 'stock_status'));
    }


    // to show the form for creating a new product
    public function createProduct()
    {
        $vendor = Auth::user();
        return view('vendor.create-product', compact('vendor'));
    }


    // store the new product in the database
    // store the new product in the database
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string|min:5',
            'sizes' => 'nullable|string',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_colors' => 'nullable|array',
        ]);

        $coverImagePath = null;
        if ($request->hasFile('images')) {
            $coverImagePath = $request->file('images')[0]->store('products', 'public');
        }

        $sizesArray = null;
        if ($request->filled('sizes')) {
            $sizesArray = array_map('trim', explode(',', strtolower($request->sizes)));
        }

        $colorsArray = [];
        if ($request->has('image_colors')) {
            foreach ($request->image_colors as $color) {
                if (!empty($color)) {
                    $colorsArray[] = strtolower(trim($color));
                }
            }
        }
        $colorsArray = array_unique($colorsArray);

        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $coverImagePath,
            'sizes' => $sizesArray ? json_encode($sizesArray) : null, // 💡 JSON စစ်စစ်အဖြစ် ဝင်သွားပါပြီ
            'colors' => !empty($colorsArray) ? json_encode(array_values($colorsArray)) : null,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                if ($file->isValid()) {
                    $path = $file->store('products/gallery', 'public');

                    $associatedColor = isset($request->image_colors[$index]) ? strtolower(trim($request->image_colors[$index])) : null;

                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'color' => !empty($associatedColor) ? $associatedColor : null,
                    ]);
                }
            }
        }

        return redirect()->route('vendor.dashboard')->with('success', 'Product uploaded successfully!');
    }


    // edit product data and show the form with existing data
    public function edit($id)
    {
        $product = Product::where('user_id', auth()->id())
            ->with('images')
            ->findOrFail($id);
        return response()->json($product);
    }


    // update product data in the database
    public function update(Request $request, $id)
    {
        $product = Product::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'sizes' => 'nullable|string',
            'colors' => 'nullable|string',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $sizesArray = $request->sizes ? array_map('trim', explode(',', strtolower($request->sizes))) : null;

        $mainColors = $request->colors ? array_map('trim', explode(',', strtolower($request->colors))) : [];

        if ($request->has('existing_image_colors')) {
            foreach ($request->existing_image_colors as $imageId => $colorValue) {
                if (!empty($colorValue)) {
                    $cleanedColor = strtolower(trim($colorValue));
                    \App\Models\ProductImage::where('id', $imageId)
                        ->where('product_id', $product->id)
                        ->update(['color' => $cleanedColor]);

                    $mainColors[] = $cleanedColor;
                } else {
                    \App\Models\ProductImage::where('id', $imageId)
                        ->where('product_id', $product->id)
                        ->update(['color' => null]);
                }
            }
        }

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $img = \App\Models\ProductImage::where('id', $imageId)->where('product_id', $product->id)->first();
                if ($img) {
                    \Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }
        }

        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $index => $imageFile) {
                $path = $imageFile->store('products/gallery', 'public');

                $color = isset($request->new_image_colors[$index]) ? strtolower(trim($request->new_image_colors[$index])) : null;

                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'color' => !empty($color) ? $color : null
                ]);

                if (!empty($color)) {
                    $mainColors[] = $color;
                }
            }
        }

        $mainColors = array_values(array_unique(array_filter($mainColors)));

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'sizes' => $sizesArray ? json_encode($sizesArray) : null,
            'colors' => !empty($mainColors) ? json_encode($mainColors) : null, // 👈 ဒီမှာ Database ထဲ စနစ်တကျ ဝင်သွားပါပြီ
        ]);

        return redirect()->back()->with('success', 'Product and image variations updated successfully!');
    }

    public function destroy($id)
    {
        // find the product for the current vendor
        $product = Product::where('user_id', auth()->id())->findOrFail($id);

        // delete the product image from storage if it exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // delete the product from the database
        $product->delete();

        // show success message
        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function orderIndex(Request $request)
    {
        $vendor = Auth::user();
        $vendorId = Auth::id();
        $status = $request->input('status', 'all');

        // 1. Base Query: မိမိ ဆိုင်၏ Order Items များကို ယူမည်
        $query = OrderItem::with('order', 'product')
            ->where('vendor_id', $vendorId);

        // Filter dropdown အတွက် Status အရ စစ်ထုတ်ခြင်း
        if ($status === 'paid') {
            $query->whereHas('order', function ($q) {
                $q->whereIn('status', ['paid']);
            });
        } elseif ($status === 'pending') {
            $query->whereHas('order', function ($q) {
                $q->whereNotIn('status', ['paid']);
            });
        }

        $myOrders = $query->latest()->get();

        // 2. Total Items Sold (Paid ဖြစ်ပြီးသား Item အရေအတွက် သီးသန့်)
        $paidItems = OrderItem::where('vendor_id', $vendorId)
            ->whereHas('order', function ($q) {
                $q->whereIn('status', ['paid']);
            })
            ->get();

        $paidItemsCount = $paidItems->sum('quantity');

        // 3. Total Net Earnings (Paid ဖြစ်ပြီးသား Item များ၏ Net Amount 98% သီးသန့်)
        $paidNetEarnings = $paidItems->sum(function ($item) {
            return $item->vendor_amount > 0
                ? $item->vendor_amount
                : (($item->price * $item->quantity) * 0.98);
        });

        // Count များတွက်ရန် (Dropdown အတွက်)
        $allOrdersCount = OrderItem::where('vendor_id', $vendorId)->count();
        $pendingOrdersCount = OrderItem::where('vendor_id', $vendorId)
            ->whereHas('order', function ($q) {
                $q->whereNotIn('status', ['paid']);
            })->count();
        $paidOrdersCount = OrderItem::where('vendor_id', $vendorId)
            ->whereHas('order', function ($q) {
                $q->whereIn('status', ['paid']);
            })->count();

        return view('vendor.orders.index', compact(
            'vendor',
            'myOrders',
            'status',
            'paidItemsCount',
            'paidNetEarnings',
            'allOrdersCount',
            'pendingOrdersCount',
            'paidOrdersCount'
        ));
    }
}
