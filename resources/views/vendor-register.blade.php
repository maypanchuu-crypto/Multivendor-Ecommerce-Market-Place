<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Registration</title>

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

        /* 3D Page Background */
        .page-3d-bg {
            background: radial-gradient(circle at 50% 0%, #fff7ed 0%, #ffedd5 50%, #f3f4f6 100%);
        }

        .dark .page-3d-bg {
            background: radial-gradient(circle at 50% 0%, #1f1917 0%, #111827 100%);
        }

        /* 3D Elevated Clay Card Effect */
        .clay-card-orange {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1.75rem;
            box-shadow:
                0 20px 30px -10px rgba(234, 88, 12, 0.15),
                0 10px 15px -5px rgba(0, 0, 0, 0.04),
                inset 0 2px 4px rgba(255, 255, 255, 0.9),
                inset 0 -3px 4px rgba(0, 0, 0, 0.05);
            border: 1.5 border;
        }

        .dark .clay-card-orange {
            background: rgba(31, 41, 55, 0.95);
            box-shadow:
                0 20px 30px -10px rgba(0, 0, 0, 0.5),
                inset 0 1px 1px rgba(255, 255, 255, 0.1);
        }

        /* 3D Input Box Effect */
        .input-3d {
            background: #fffaf5;
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.2s ease;
        }

        .dark .input-3d {
            background: #374151;
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.3);
        }

        .input-3d:focus {
            background: #ffffff;
            box-shadow:
                inset 0 2px 4px 0 rgba(0, 0, 0, 0.02),
                0 0 0 3px rgba(234, 88, 12, 0.25);
        }

        .dark .input-3d:focus {
            background: #1f2937;
        }

        /* 3D Interactive Orange-Red Push Button */
        .btn-3d-orange {
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
            box-shadow:
                0 6px 0 0 #9a3412,
                0 12px 20px rgba(234, 88, 12, 0.35);
            transition: all 0.15s ease-in-out;
        }

        .btn-3d-orange:hover:not(:disabled) {
            transform: translateY(2px);
            box-shadow:
                0 4px 0 0 #9a3412,
                0 8px 15px rgba(234, 88, 12, 0.3);
        }

        .btn-3d-orange:active:not(:disabled) {
            transform: translateY(6px);
            box-shadow:
                0 0 0 0 #9a3412,
                0 2px 5px rgba(234, 88, 12, 0.2);
        }

        .btn-3d-orange:disabled {
            background: #cbd5e1;
            box-shadow: 0 4px 0 0 #94a3b8;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .dark .btn-3d-orange:disabled {
            background: #4b5563;
            box-shadow: 0 4px 0 0 #374151;
        }
    </style>
</head>

<body class="page-3d-bg text-gray-900 dark:text-gray-100 min-h-screen pb-24 relative overflow-x-hidden">

    <main class="max-w-2xl mx-auto px-4 py-10">
        <div
            class="clay-card-orange p-6 md:p-10 border border-orange-100 dark:border-gray-700 relative overflow-hidden">

            <!-- Top Orange Accent Bar -->
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-orange-500 via-rose-500 to-amber-500">
            </div>

            <div class="mb-8 text-center pt-2">
                <div
                    class="inline-flex p-3 rounded-2xl bg-orange-100 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 mb-3 shadow-inner border border-orange-200 dark:border-orange-800">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 11h14a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white mb-1">Register Your Shop
                </h1>
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Fill in the details to send a request
                    to the system administrator.</p>
            </div>

            @if(session('success'))
                <div
                    class="mb-6 bg-emerald-50 dark:bg-emerald-950/30 border-2 border-emerald-300 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm p-4 rounded-2xl shadow-sm flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if($user->vendor_status === 'pending')
                <div
                    class="text-center py-8 px-4 bg-amber-50 dark:bg-amber-950/30 border-2 border-amber-300 dark:border-amber-800/60 rounded-2xl flex flex-col items-center justify-center gap-3 shadow-inner">
                    <svg class="w-12 h-12 text-amber-500 animate-pulse" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="font-extrabold text-amber-800 dark:text-amber-400 text-lg">Request Pending</h3>
                    <p class="text-xs font-medium text-amber-700 dark:text-amber-500/90 max-w-md leading-relaxed">
                        သင်တင်ထားသော ဆိုင်အချက်အလက်များကို Admin မှ စစ်ဆေးနေဆဲ ဖြစ်ပါသည်။ အတည်ပြုပြီးပါက Vendor စနစ်ကို
                        စတင်အသုံးပြုနိုင်ပါမည်။
                    </p>
                    <div
                        class="mt-2 text-xs bg-white dark:bg-gray-700 px-4 py-2 rounded-xl shadow-sm border border-amber-200 dark:border-gray-600">
                        <span class="text-gray-400">Submitted Shop Name:</span>
                        <strong class="text-gray-800 dark:text-white font-bold">{{ $user->shop_name }}</strong>
                    </div>
                </div>

            @elseif($user->vendor_status === 'rejected')
                <div
                    class="mb-6 bg-rose-50 dark:bg-rose-950/30 border-2 border-rose-300 dark:border-rose-800 text-rose-600 dark:text-rose-400 text-xs font-bold p-4 rounded-2xl shadow-sm">
                    သင်၏ ယခင်တင်ထားသော တောင်းဆိုမှုကို Admin မှ ငြင်းပယ်ထားပါသည်။ အချက်အလက်များကို ပြန်လည်ပြင်ဆင်၍ Form
                    ပြန်တင်နိုင်ပါသည်။
                </div>
            @endif

            @if($user->vendor_status !== 'pending')
                    <form action="{{ route('vendor.register.submit') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="shop_name"
                                class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Shop
                                Name</label>
                            <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name', $user->shop_name) }}"
                                pattern="([A-Z][a-zA-Z0-9&'\s()]*)+"
                                title="Each word must start with an uppercase letter, followed by lowercase letters, numbers, or special characters '&', ''', '(', ')'."
                                oninput="
                                let val = this.value;
                                
                                    this.value = val.replace(/[^a-zA-Z]/g, '');
                                } else if (val.length > 1) {
                                    let firstChar = val.charAt(0).toUpperCase();
                                    let remaining = val.slice(1).replace(/[^a-zA-Z0-9\s&'()]/g, '');
                                    this.value = firstChar + remaining;
                                }
                            " class="input-3d w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-2xl text-sm font-bold focus:outline-none dark:text-white @error('shop_name') border-rose-500 @enderror"
                                            placeholder="Enter your shop name">
                            @error('shop_name')
                            <p class="text-rose-500 text-[11px] mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="shop_phone"
                                class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Contact
                                Phone Number</label>
                            <input type="text" id="shop_phone" name="shop_phone"
                                value="{{ old('shop_phone', $user->shop_phone ?? '09') }}" maxlength="11" minlength="8"
                                pattern="09[0-9]{6,9}"
                                title="Phone number must start with 09 and contain 8 to 11 digits in total." oninput="

                                            let val = this.value.replace(/[^0-9]/g, '');

                                            if (!val.startsWith('09')) {
                                                val = '09' + val.replace(/^0+/, '');
                                            }

                                            if (val.length > 11) {
                                                val = val.slice(0, 11);
                                            }

                                            this.value = val;
                                        " onkeydown="

                                            if ((event.key === 'Backspace' || event.key === 'Delete') && this.selectionStart <= 2) {
                                                event.preventDefault();
                                            }
                                        "
                                class="input-3d w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-2xl text-sm font-bold focus:outline-none dark:text-white @error('shop_phone') border-rose-500 @enderror"
                                placeholder="09*********">
                            @error('shop_phone')
                                <p class="text-rose-500 text-[11px] mt-1 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="shop_description"
                                class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Shop
                                Description</label>
                            <textarea id="shop_description" name="shop_description" rows="3"
                                class="input-3d w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-2xl text-sm font-bold focus:outline-none dark:text-white @error('shop_description') border-rose-500 @enderror"
                                placeholder="What are you selling?">{{ old('shop_description', $user->shop_description) }}</textarea>
                            @error('shop_description')
                                <p class="text-rose-500 text-[11px] mt-1 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 💡 SINGLE CONTAINER: NOTE (YELLOW & LARGER SIZE) + CHECKBOX BELOW -->
                        <div
                            class="bg-amber-500/10 dark:bg-amber-500/15 border-2 border-amber-400/80 dark:border-amber-500/50 rounded-2xl p-4.5 shadow-sm space-y-4">

                            <!-- 1. Yellow Note Text (Larger Size) -->
                            <div class="flex items-start gap-2.5">
                                <span class="text-amber-500 text-lg font-black leading-none mt-0.5">⚠️</span>
                                <p class="text-sm font-black text-amber-600 dark:text-amber-400 leading-relaxed">
                                    Vendor ဘက်မှ ရောင်းထွက်သွားသည့် ကုန်ပစ္စည်း ၁ ခုချင်းစီ၏ ဈေးနှုန်းမှ ၂ ရာခိုင်နှုန်း ကို
                                    ကော်မရှင်အဖြစ် ကောက်ခံသွားပါမည်။
                                </p>
                            </div>

                            <!-- Divider Line for separation -->
                            <div class="border-t border-amber-200 dark:border-amber-800/40"></div>

                            <!-- 2. Checkbox & Acceptance Text (Smaller Size) -->
                            <div class="flex items-center gap-3 pt-0.5">
                                <input type="checkbox" id="accept_terms" onchange="toggleSubmitButton()"
                                    class="w-5 h-5 rounded-lg text-orange-600 border-2 border-amber-400 focus:ring-orange-500 cursor-pointer flex-shrink-0">

                                <label for="accept_terms"
                                    class="text-xs font-extrabold text-gray-700 dark:text-gray-300 cursor-pointer select-none">
                                    အထက်ပါ စည်းကမ်းချက်ကို လက်ခံပါသည်။
                                </label>
                            </div>
                        </div>

                        <!-- 💡 SUBMIT BUTTON (Initially Disabled) -->
                        <div>
                            <button type="submit" id="submitBtn" disabled
                                class="btn-3d-orange w-full text-white font-black text-sm py-4 rounded-2xl transition-all tracking-wider uppercase">
                                Submit Registration Request
                            </button>
                        </div>
                    </form>
            @endif

        </div>
    </main>

    <script>
        // Checkbox Toggle Logic
        function toggleSubmitButton() {
            const checkbox = document.getElementById('accept_terms');
            const submitBtn = document.getElementById('submitBtn');

            if (checkbox && submitBtn) {
                submitBtn.disabled = !checkbox.checked;
            }
        }

        // Dark Mode Logic
        const darkModeRow = document.getElementById('darkModeRow');
        const darkModeToggle = document.getElementById('darkModeToggle');

        function updateTheme(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                if (darkModeToggle) darkModeToggle.checked = true;
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                if (darkModeToggle) darkModeToggle.checked = false;
            }
        }

        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            updateTheme(true);
        } else {
            updateTheme(false);
        }

        if (darkModeRow && darkModeToggle) {
            darkModeRow.addEventListener('click', () => {
                updateTheme(!darkModeToggle.checked);
            });
        }
    </script>
</body>

</html>