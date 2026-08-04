<!DOCTYPE html>
<x-app-layout :hideNav="true">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="text-base font-black tracking-wide text-orange-500 dark:text-orange-400">
                {{ $vendor->shop_name }}
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 ml-1"></span>
            </h2>
        </div>
    </x-slot>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add New Product - {{ $vendor->shop_name }}</title>

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
            }
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <style>
            html,
            body {
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            /* 💡 Browsers အားလုံးအတွက် Scrollbar ဖျောက်ရန် */
            ::-webkit-scrollbar {
                display: none;
            }

            html,
            body {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            /* 💡 Body နှင့် Background အရောင် (Dashboard ပုံစံအတိုင်း) */
            body,
            div.min-h-screen {
                background-color: #d1fae5 !important;
                /* Fresh Emerald 100 */
            }

            /* Dark Mode အတွက် */
            html.dark body,
            html.dark div.min-h-screen {
                background-color: #064e3b !important;
                /* Dark Fresh Emerald 900 */
            }

            /* 💡 3D Solid Block Buttons & Cards */
            .btn-3d {
                transition: all 0.15s ease;
                border: 2px solid #065f46;
                box-shadow: 3px 4px 0px 0px #065f46;
            }

            .btn-3d:hover {
                transform: translateY(-2px);
                box-shadow: 4px 6px 0px 0px #065f46;
            }

            .btn-3d:active {
                transform: translateY(2px);
                box-shadow: 1px 1px 0px 0px #065f46;
            }

            html.dark .btn-3d {
                border-color: #a7f3d0;
                box-shadow: 3px 4px 0px 0px #a7f3d0;
            }

            /* Price Input ဘေးက Up/Down Arrows ဖျောက်ရန် */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type=number] {
                -moz-appearance: textfield;
            }
        </style>
    </head>

    <body class="text-gray-900 dark:text-gray-100 min-h-screen pb-24 relative overflow-x-hidden">

        <main class="max-w-2xl mx-auto px-4 py-8">            

            <!-- 💡 Main 3D Card Container -->
            <div
                class="bg-white dark:bg-emerald-900 rounded-2xl p-6 md:p-8 border-2 border-emerald-800 dark:border-emerald-300 shadow-[4px_6px_0px_0px_#065f46] dark:shadow-[4px_6px_0px_0px_#a7f3d0]">

                <div class="mb-6 border-b-2 border-emerald-800/20 dark:border-emerald-300/20 pb-4">
                    <h1 class="text-2xl font-black text-orange-600 dark:text-orange-400 tracking-wide uppercase">Upload
                        New Item 🚀</h1>
                    <p class="text-xs text-emerald-800 dark:text-emerald-200 font-bold mt-1">Fill in the details to list
                        a new product in the marketplace.</p>
                </div>

                @if ($errors->any())
                    <div
                        class="bg-rose-100 dark:bg-rose-950/80 border-2 border-rose-500 text-rose-700 dark:text-rose-200 px-4 py-3 rounded-xl relative mb-6 shadow-[3px_3px_0px_0px_#e11d48] text-xs font-bold">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('vendor.product.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf

                    <!-- Product Name -->
                    <div>
                        <label for="name"
                            class="block text-xs font-black text-emerald-950 dark:text-emerald-100 uppercase mb-2">Product
                            Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2.5 bg-emerald-50 dark:bg-emerald-950 border-2 border-emerald-800 dark:border-emerald-300 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-orange-500 dark:text-white shadow-[2px_3px_0px_0px_#065f46] dark:shadow-[2px_3px_0px_0px_#a7f3d0]"
                            placeholder="e.g. Close Up Toothpaste">
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price"
                            class="block text-xs font-black text-emerald-950 dark:text-emerald-100 uppercase mb-2">Price
                            (MMK)</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" required
                            class="w-full px-4 py-2.5 bg-emerald-50 dark:bg-emerald-950 border-2 border-emerald-800 dark:border-emerald-300 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-orange-500 dark:text-white shadow-[2px_3px_0px_0px_#065f46] dark:shadow-[2px_3px_0px_0px_#a7f3d0]"
                            placeholder="e.g. 70000">
                    </div>

                    <!-- Product Description -->
                    <div>
                        <label for="description"
                            class="block text-xs font-black text-emerald-950 dark:text-emerald-100 uppercase mb-2">Product
                            Description</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-4 py-2.5 bg-emerald-50 dark:bg-emerald-950 border-2 border-emerald-800 dark:border-emerald-300 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-orange-500 dark:text-white shadow-[2px_3px_0px_0px_#065f46] dark:shadow-[2px_3px_0px_0px_#a7f3d0]"
                            placeholder="Toothpaste description...">{{ old('description') }}</textarea>
                    </div>

                    <!-- 🔘 Color Checkbox Switch -->
                    <div
                        class="flex items-center gap-3 p-4 bg-emerald-100/60 dark:bg-emerald-950/80 rounded-xl border-2 border-emerald-800 dark:border-emerald-300 mt-6 shadow-[2px_3px_0px_0px_#065f46] dark:shadow-[2px_3px_0px_0px_#a7f3d0]">
                        <input type="checkbox" id="has_colors" name="has_colors" value="1"
                            onchange="toggleColorSection()"
                            class="w-4 h-4 text-orange-600 rounded focus:ring-orange-500 cursor-pointer">
                        <label for="has_colors"
                            class="text-xs font-black text-emerald-950 dark:text-emerald-100 cursor-pointer select-none">
                            🎨 This product has multiple color variants
                        </label>
                    </div>

                    <!-- =================================================== -->
                    <!-- 1️⃣ OPTION A: Single Stock + Multiple Images -->
                    <!-- =================================================== -->
                    <div id="noColorSection" class="space-y-4 pt-2">
                        <div>
                            <label for="total_stock"
                                class="block text-xs font-black text-emerald-950 dark:text-emerald-100 uppercase mb-2">Stock
                                Quantity</label>
                            <input type="number" id="total_stock" name="stock" min="0" value="1"
                                class="w-full px-4 py-2.5 bg-emerald-50 dark:bg-emerald-950 border-2 border-emerald-800 dark:border-emerald-300 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-orange-500 dark:text-white shadow-[2px_3px_0px_0px_#065f46] dark:shadow-[2px_3px_0px_0px_#a7f3d0]">
                        </div>

                        <div>
                            <label
                                class="block text-xs font-black text-emerald-950 dark:text-emerald-100 uppercase mb-1">Product
                                Images (Max size 2MB)</label>
                            <p class="text-xs text-emerald-800 dark:text-emerald-200 font-bold mb-3">You can select many
                                images at once.</p>

                            <input type="file" id="multiImageInput" name="images[]" multiple accept="image/*"
                                onchange="previewImages(event)"
                                class="w-full px-4 py-2.5 bg-emerald-50 dark:bg-emerald-950 border-2 border-emerald-800 dark:border-emerald-300 rounded-xl text-xs font-bold text-emerald-950 dark:text-white shadow-[2px_3px_0px_0px_#065f46] dark:shadow-[2px_3px_0px_0px_#a7f3d0] cursor-pointer">
                        </div>

                        <!-- Image Previews Container -->
                        <div id="imagePreviewContainer"
                            class="grid grid-cols-2 gap-4 p-4 bg-emerald-100/50 dark:bg-emerald-950/50 rounded-xl border-2 border-emerald-800 dark:border-emerald-300 hidden">
                            <!-- JavaScript မှ Preview ပုံများပြမည် -->
                        </div>
                    </div>

                    <!-- =================================================== -->
                    <!-- 2️⃣ OPTION B: Color + Stock + Image Dynamic Rows -->
                    <!-- =================================================== -->
                    <div id="colorSection" class="space-y-4 pt-2 hidden">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-black text-orange-600 dark:text-orange-400">🎨 Product Colors &
                                Stock</h3>
                            <button type="button" onclick="addColorRow()"
                                class="px-3 py-1.5 bg-orange-500 text-white rounded-xl text-xs font-black border-2 border-orange-700 shadow-[2px_2px_0px_0px_#c2410c] hover:bg-orange-600">
                                + Add Color Option
                            </button>
                        </div>

                        <div id="colorVariantContainer" class="space-y-3">
                            <!-- Initial Variant Row -->
                            <div
                                class="color-row p-3 bg-emerald-50 dark:bg-emerald-950/60 rounded-xl border-2 border-emerald-800 dark:border-emerald-300 grid grid-cols-1 sm:grid-cols-3 gap-3 items-center shadow-[2px_2px_0px_0px_#065f46]">
                                <div>
                                    <label
                                        class="block text-[10px] font-black uppercase text-emerald-800 dark:text-emerald-200">Color
                                        Name</label>
                                    <input type="text" name="variants[0][color_name]" placeholder="e.g. Red, Black"
                                        class="w-full px-3 py-1.5 bg-white dark:bg-emerald-900 border-2 border-emerald-800 rounded-lg text-xs font-bold dark:text-white focus:outline-none">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-black uppercase text-emerald-800 dark:text-emerald-200">Stock
                                        Quantity</label>
                                    <input type="number" name="variants[0][stock]" min="0" value="1"
                                        class="w-full px-3 py-1.5 bg-white dark:bg-emerald-900 border-2 border-emerald-800 rounded-lg text-xs font-bold dark:text-white focus:outline-none">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-black uppercase text-emerald-800 dark:text-emerald-200">Color
                                        Image</label>
                                    <input type="file" name="variants[0][image]" accept="image/*"
                                        class="w-full text-xs text-emerald-950 dark:text-emerald-200">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="btn-3d w-full bg-orange-500 hover:bg-orange-600 text-white font-black text-sm py-3.5 rounded-xl border-2 border-orange-700 shadow-[3px_4px_0px_0px_#c2410c] transition-all">
                            Publish Product 🚀
                        </button>
                    </div>
                </form>

            </div>
        </main>

        <script>
            // --- Checkbox toggle logic ---
            function toggleColorSection() {
                const hasColors = document.getElementById('has_colors').checked;
                const colorSection = document.getElementById('colorSection');
                const noColorSection = document.getElementById('noColorSection');

                if (hasColors) {
                    colorSection.classList.remove('hidden');
                    noColorSection.classList.add('hidden');
                } else {
                    colorSection.classList.add('hidden');
                    noColorSection.classList.remove('hidden');
                }
            }

            // --- Preview Images for Single Stock Mode ---
            function previewImages(event) {
                const container = document.getElementById('imagePreviewContainer');
                container.innerHTML = '';
                const files = event.target.files;

                if (files.length > 0) {
                    container.classList.remove('hidden');

                    Array.from(files).forEach((file) => {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const card = document.createElement('div');
                            card.className = "bg-white dark:bg-emerald-950 p-2 rounded-xl shadow-[2px_2px_0px_0px_#065f46] border-2 border-emerald-800 dark:border-emerald-300";
                            card.innerHTML = `
                                <div class="h-32 rounded-lg overflow-hidden bg-emerald-50 flex items-center justify-center">
                                    <img src="${e.target.result}" class="h-full object-cover w-full">
                                </div>
                            `;
                            container.appendChild(card);
                        }
                        reader.readAsDataURL(file);
                    });
                } else {
                    container.classList.add('hidden');
                }
            }

            // --- Add Dynamic Color Rows ---
            let colorRowIndex = 1;
            function addColorRow() {
                const container = document.getElementById('colorVariantContainer');
                const div = document.createElement('div');
                div.className = 'color-row p-3 bg-emerald-50 dark:bg-emerald-950/60 rounded-xl border-2 border-emerald-800 dark:border-emerald-300 grid grid-cols-1 sm:grid-cols-3 gap-3 items-center relative shadow-[2px_2px_0px_0px_#065f46]';
                div.innerHTML = `
                    <div>
                        <label class="block text-[10px] font-black uppercase text-emerald-800 dark:text-emerald-200">Color Name</label>
                        <input type="text" name="variants[${colorRowIndex}][color_name]" placeholder="e.g. Blue" 
                            class="w-full px-3 py-1.5 bg-white dark:bg-emerald-900 border-2 border-emerald-800 rounded-lg text-xs font-bold dark:text-white focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-emerald-800 dark:text-emerald-200">Stock Quantity</label>
                        <input type="number" name="variants[${colorRowIndex}][stock]" min="0" value="1" 
                            class="w-full px-3 py-1.5 bg-white dark:bg-emerald-900 border-2 border-emerald-800 rounded-lg text-xs font-bold dark:text-white focus:outline-none">
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex-1">
                            <label class="block text-[10px] font-black uppercase text-emerald-800 dark:text-emerald-200">Color Image</label>
                            <input type="file" name="variants[${colorRowIndex}][image]" accept="image/*" class="w-full text-xs text-emerald-950 dark:text-emerald-200">
                        </div>
                        <button type="button" onclick="this.closest('.color-row').remove()" class="mt-4 text-rose-500 font-black text-sm p-1">✕</button>
                    </div>
                `;
                container.appendChild(div);
                colorRowIndex++;
            }
        </script>
    </body>

    </html>
</x-app-layout>