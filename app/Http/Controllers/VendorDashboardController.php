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
                    ->whereDate('created_at', \Carbon\Carbon::today());
            })
            ->get();

        $totalOrders = $todayPaidItems->count();

        $totalEarnings = $todayPaidItems->sum(function ($item) {
            return $item->vendor_amount > 0
                ? $item->vendor_amount
                : (($item->price * $item->quantity) * 0.98);
        });

        // 💡 Relation များ (`images` နှင့် `colorVariants`) ကို with() ဖြင့် တွဲခေါ်ပါ
        $query = Product::where('user_id', $vendor->id)
            ->with(['images', 'colorVariants']);

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
        // Color ပါ/မပါ Checkbox စစ်ပါမည်
        $hasColors = $request->has('has_colors');

        // 1. Validation Logic
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|min:5',
            'sizes' => 'nullable|string',
        ];

        if ($hasColors) {
            // Color Variant ပါပါက
            $rules['variants'] = 'required|array|min:1';
            $rules['variants.*.color_name'] = 'required|string';
            $rules['variants.*.stock'] = 'required|integer|min:0';
            $rules['variants.*.image'] = 'nullable|image|max:2048';
        } else {
            // Color Variant မပါပါက (Single Stock + Multiple Images)
            $rules['stock'] = 'required|integer|min:0';
            $rules['images'] = 'required|array|min:1';
            $rules['images.*'] = 'image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        $request->validate($rules);

        // 2. Stock နဲ့ Cover Image ကို စစ်ဆေးခြင်း
        if ($hasColors) {
            $totalStock = collect($request->variants)->sum('stock');
            $coverImagePath = isset($request->variants[0]['image'])
                ? $request->variants[0]['image']->store('products', 'public')
                : null;
        } else {
            $totalStock = $request->stock; // Form ကလာသည့် မူလ Stock ကိုယူမည်
            $coverImagePath = isset($request->file('images')[0])
                ? $request->file('images')[0]->store('products', 'public')
                : null;
        }

        // 3. Product တည်ဆောက်ခြင်း
        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $totalStock,
            'sizes' => $request->sizes,
            'description' => $request->description,
            'image' => $coverImagePath,
        ]);

        // 4. CASE A: Color Variants ရှိလျှင် product_colors Table ထဲသိမ်းမည်
        if ($hasColors) {
            foreach ($request->variants as $variant) {
                $imgPath = null;
                if (isset($variant['image']) && $variant['image']->isValid()) {
                    $imgPath = $variant['image']->store('products/colors', 'public');
                }

                $product->colorVariants()->create([
                    'color_name' => strtolower(trim($variant['color_name'])),
                    'stock' => $variant['stock'],
                    'image_path' => $imgPath,
                ]);
            }
        }
        // 5. CASE B: Color Variants မရှိလျှင် product_images Table ထဲသိမ်းမည်
        else {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $imgPath = $imageFile->store('products/gallery', 'public');

                    $product->images()->create([
                        'image_path' => $imgPath,
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
            ->with(['images', 'colorVariants'])
            ->findOrFail($id);

        return response()->json($product);
    }


    // update product data in the database
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // 1. Validation များကို စစ်ဆေးပါ (new_images ကိုပါ ထည့်စစ်ရန်)
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'color_variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. Main Cover Image အသစ်တင်လာလျှင် ပုံဟောင်းဖျက်၍ အသစ်အစားထိုးရန်
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        // 3. General Product Details များကို Update လုပ်ရန်
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;

        // Sizes များကို JSON ဖြင့် သိမ်းဆည်းရန်
        if ($request->has('sizes')) {
            // Comma separated string လာလျှင် Array ပြောင်းပြီးမှ json_encode လုပ်ရန်
            $sizesInput = $request->sizes;
            if (is_string($sizesInput)) {
                $sizesArray = array_map('trim', explode(',', $sizesInput));
                $product->sizes = json_encode($sizesArray);
            } else {
                $product->sizes = json_encode($sizesInput);
            }
        } else {
            $product->sizes = null;
        }

        $product->save();

        // 4. Checkbox ဖြင့် Color (သို့) Non-Color ပြောင်းလဲမှုကို စစ်ဆေးခြင်း
        $hasColors = $request->has('has_colors');

        if ($hasColors) {
            // 💡 ၁။ ပေးလာတဲ့ Existing နှင့် New Variants များ၏ Stock များကို ပေါင်း၍ Product Stock ထဲ ထည့်ရန်
            $totalVariantStock = 0;

            if ($request->has('existing_variants')) {
                foreach ($request->existing_variants as $exVar) {
                    if (!in_array($exVar['id'], $request->input('delete_variants', []))) {
                        $totalVariantStock += (int) ($exVar['stock'] ?? 0);
                    }
                }
            }
            if ($request->has('new_variants')) {
                foreach ($request->new_variants as $newVar) {
                    $totalVariantStock += (int) ($newVar['stock'] ?? 0);
                }
            }
            $product->stock = $totalVariantStock;
            $product->save();

            // 💡 ၂။ Non-color ပုံဟောင်းများ ရှိခဲ့ပါက ဖျက်ရန်
            foreach ($product->images as $img) {
                if (Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
                $img->delete();
            }

            // 💡 ၃။ အသုံးပြုသူ ဖျက်ရန် ရွေးချယ်ထားသော Existing Color Variants များကို ဖျက်မည်
            if ($request->has('delete_variants')) {
                $variantsToDelete = \App\Models\ProductColor::whereIn('id', $request->delete_variants)
                    ->where('product_id', $product->id)
                    ->get();

                foreach ($variantsToDelete as $delVar) {
                    if ($delVar->image_path && Storage::disk('public')->exists($delVar->image_path)) {
                        Storage::disk('public')->delete($delVar->image_path);
                    }
                    $delVar->delete();
                }
            }

            // 💡 ၄။ ရှိပြီးသား Existing Color Variants များကို Update လုပ်မည်
            if ($request->has('existing_variants')) {
                foreach ($request->existing_variants as $index => $exData) {
                    // ဖျက်ဖို့ ရွေးထားပြီးသားဆိုရင် ကျော်လိုက်မယ်
                    if (in_array($exData['id'], $request->input('delete_variants', []))) {
                        continue;
                    }

                    $colorVariant = \App\Models\ProductColor::where('id', $exData['id'])
                        ->where('product_id', $product->id)
                        ->first();

                    if ($colorVariant) {
                        $colorVariant->color_name = strtolower(trim($exData['color_name'] ?? ''));
                        $colorVariant->stock = $exData['stock'] ?? 0;

                        // ပုံအသစ် တင်လာမှသာ ပုံဟောင်းဖျက်၍ အစားထိုးမည်
                        if ($request->hasFile("existing_variants.{$index}.image")) {
                            if ($colorVariant->image_path && Storage::disk('public')->exists($colorVariant->image_path)) {
                                Storage::disk('public')->delete($colorVariant->image_path);
                            }
                            $imgFile = $request->file("existing_variants")[$index]['image'];
                            $colorVariant->image_path = $imgFile->store('products/colors', 'public');
                        }

                        $colorVariant->save();
                    }
                }
            }

            // 💡 ၅။ အရောင်အသစ် ထပ်ထည့်လာပါက သိမ်းဆည်းမည်
            if ($request->has('new_variants')) {
                foreach ($request->new_variants as $index => $newVarData) {
                    $colorImagePath = null;
                    if ($request->hasFile("new_variants.{$index}.image")) {
                        $imgFile = $request->file("new_variants")[$index]['image'];
                        $colorImagePath = $imgFile->store('products/colors', 'public');
                    }

                    $product->colorVariants()->create([
                        'color_name' => strtolower(trim($newVarData['color_name'] ?? '')),
                        'stock' => $newVarData['stock'] ?? 0,
                        'image_path' => $colorImagePath,
                    ]);
                }
            }
        } else {
            // 💡 Color မပါတော့ဘဲ Non-Color (Gallery) ပုံစံသို့ ပြောင်းလိုက်လျှင် product_colors များကို ဖျက်မည်
            foreach ($product->colorVariants as $oldColorVar) {
                if ($oldColorVar->image_path && Storage::disk('public')->exists($oldColorVar->image_path)) {
                    Storage::disk('public')->delete($oldColorVar->image_path);
                }
                $oldColorVar->delete();
            }

            // အသုံးပြုသူ Checkbox မှတစ်ဆင့် သီးသန့်ဖျက်ရန် ရွေးချယ်ထားသော ပုံဟောင်းများ (`delete_images[]`) ကို ဖျက်မည်
            if ($request->has('delete_images')) {
                $imagesToDelete = ProductImage::whereIn('id', $request->delete_images)
                    ->where('product_id', $product->id)
                    ->get();

                foreach ($imagesToDelete as $img) {
                    if (Storage::disk('public')->exists($img->image_path)) {
                        Storage::disk('public')->delete($img->image_path);
                    }
                    $img->delete();
                }
            }

            // 💡 ပုံအသစ်များ (`new_images`) ပါလာလျှင် `product_images` ထဲသို့ ထည့်မည်
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $imageFile) {
                    $path = $imageFile->store('products/gallery', 'public');
                    $product->images()->create([
                        'image_path' => $path
                    ]);
                }
            }

            // 💡 Product table ထဲက Main Cover Image (`$product->image`) ပျက်သွားခဲ့လျှင် သို့မဟုတ် မရှိတော့လျှင် 
            // ကျန်ရှိနေတဲ့ Gallery ပုံများထဲမှ ပထမဆုံးပုံကို Cover Image အဖြစ် အလိုအလျောက် အစားထိုးပေးမည်
            $remainingImages = $product->images()->latest()->get();
            if ($remainingImages->count() > 0) {
                if (!$product->image || !Storage::disk('public')->exists($product->image)) {
                    $product->image = $remainingImages->first()->image_path;
                    $product->save();
                }
            } else {
                // ပုံလုံးဝမရှိတော့လျှင် Cover image ကို null လုပ်ပေးပါ
                if (!$request->hasFile('image')) {
                    $product->image = null;
                    $product->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully!');
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
