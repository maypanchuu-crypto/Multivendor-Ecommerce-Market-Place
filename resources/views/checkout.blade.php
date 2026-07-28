<x-app-layout :hideNav="true">
    <!-- 💡 Custom 3D & Claymorphism Styling -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Subtle Background Gradient for 3D Pop Effect */
        .page-3d-bg {
            background: radial-gradient(circle at 50% 0%, #f0fdf4 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        /* 3D Box Soft Clay Effect */
        .clay-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1.5rem;
            box-shadow:
                0 20px 30px -10px rgba(0, 0, 0, 0.07),
                0 10px 15px -5px rgba(0, 0, 0, 0.04),
                inset 0 2px 4px rgba(255, 255, 255, 0.8),
                inset 0 -2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        /* 3D Input Box Effect */
        .input-3d {
            background: #f8fafc;
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.2s ease;
        }

        .input-3d:focus {
            background: #ffffff;
            box-shadow:
                inset 0 2px 4px 0 rgba(0, 0, 0, 0.02),
                0 0 0 3px rgba(16, 185, 129, 0.25);
        }

        /* 3D Interactive Button */
        .btn-3d {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow:
                0 6px 0 0 #047857,
                0 12px 20px rgba(16, 185, 129, 0.35);
            transition: all 0.15s ease-in-out;
        }

        .btn-3d:hover:not(:disabled) {
            transform: translateY(2px);
            box-shadow:
                0 4px 0 0 #047857,
                0 8px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-3d:active:not(:disabled) {
            transform: translateY(6px);
            box-shadow:
                0 0 0 0 #047857,
                0 2px 5px rgba(16, 185, 129, 0.2);
        }
    </style>

    <div class="page-3d-bg py-10 px-4">
        <div class="container mx-auto max-w-4xl" x-data="checkoutForm()">

            <!-- Page Header with 3D Badge -->
            <div class="flex items-center space-x-3 mb-8">
                <div
                    class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Checkout Shipping Details</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- LEFT: SHIPPING FORM -->
                <div class="clay-card p-7 relative overflow-hidden">
                    <!-- Top Subtle Decorative Accent -->
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-400 to-teal-500">
                    </div>

                    <h2 class="font-black mb-6 text-xl text-slate-800 flex items-center gap-2">
                        <span>Shipping Information</span>
                    </h2>

                    <!-- Validation Warning Message -->
                    <template x-if="errorMessage">
                        <div class="p-3.5 mb-5 bg-rose-50 border-2 border-rose-200 text-rose-600 text-xs font-bold rounded-2xl shadow-sm flex items-center gap-2"
                            x-text="errorMessage"></div>
                    </template>

                    <form @submit.prevent="submitOrder()" class="space-y-5">
                        @csrf
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Customer
                                Name *</label>
                            <input type="text"
                                class="input-3d w-full border border-slate-200 p-3 rounded-2xl text-sm font-bold text-slate-700 outline-none"
                                x-model="customer_name" placeholder="Enter recipient name...">
                        </div>

                        <!-- 💡 PHONE INPUT BOX WITH 3D BADGE -->
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Phone
                                Number *</label>
                            <div class="relative flex items-center">
                                <!-- 3D Styled Prefix Badge -->
                                <span
                                    class="absolute left-3 bg-emerald-100 border border-emerald-200 text-emerald-800 text-xs font-black px-2.5 py-1 rounded-xl select-none shadow-sm">
                                    09
                                </span>

                                <input type="text" maxlength="9"
                                    class="input-3d w-full border border-slate-200 p-3 pl-14 rounded-2xl text-sm font-bold text-slate-700 outline-none"
                                    x-model="phoneSuffix" @input="filterPhoneInput($event)" placeholder="xxxxxxxxx">
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Delivery
                                Address *</label>
                            <textarea
                                class="input-3d w-full border border-slate-200 p-3 rounded-2xl text-sm font-semibold text-slate-700 outline-none"
                                x-model="address" rows="3" placeholder="Enter full address..."></textarea>
                        </div>

                        <button type="submit" @if($total <= 0) disabled @endif
                            class="btn-3d w-full disabled:opacity-50 disabled:cursor-not-allowed text-white font-black py-4 rounded-2xl transition text-base tracking-wide mt-2">
                            Order Now
                        </button>
                    </form>
                </div>

                <!-- RIGHT: SUMMARY -->
                <div class="clay-card p-7 h-fit relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-teal-400 to-emerald-500">
                    </div>

                    <h2 class="font-black mb-6 text-xl text-slate-800">Order Summary</h2>

                    <!-- 3D Inner Display Box -->
                    <div
                        class="bg-slate-50 border border-slate-200/80 p-5 rounded-2xl shadow-inner flex flex-col gap-2">
                        <span class="font-bold text-xs text-slate-400 uppercase tracking-wider">Total Amount</span>
                        <div class="flex items-baseline justify-between">
                            <span class="text-3xl font-black text-emerald-600 drop-shadow-sm">
                                {{ number_format($total) }}
                            </span>
                            <span class="text-sm font-extrabold text-slate-500">MMK</span>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-400 font-medium px-1">
                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1fr 1fr 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Payment Processing</span>
                    </div>
                </div>
            </div>

            <!-- 💡 3D QR CODE MODAL -->
            <div x-cloak x-show="showModal"
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-md flex items-center justify-center p-4 z-50">
                <div
                    class="clay-card p-7 w-96 text-center shadow-2xl flex flex-col items-center transform transition-all relative scale-100">

                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3 shadow-sm border border-emerald-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                            </path>
                        </svg>
                    </div>

                    <h2 class="font-black text-xl text-slate-800 mb-1">Scan QR Code to Pay</h2>
                    <!-- <p class="text-xs font-semibold text-slate-400 mb-5">Please scan with your mobile app</p> -->

                    <!-- QR Image 3D Frame Wrapper -->
                    <div
                        class="p-4 bg-slate-50 border-2 border-slate-200 rounded-3xl mb-4 shadow-inner min-h-[220px] flex items-center justify-center w-full relative">
                        <template x-if="qrCode">
                            <img :src="qrCode" alt="Payment QR Code"
                                class="w-52 h-52 mx-auto rounded-2xl shadow-md border border-white">
                        </template>
                    </div>

                    <div
                        class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-full mb-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                        <p class="text-xs text-emerald-700 font-extrabold tracking-wide">
                            waiting for payment confirmation...
                        </p>
                    </div>

                    <button @click="closeModal()"
                        class="mt-3 text-xs font-bold text-slate-400 hover:text-slate-600 transition underline decoration-2 underline-offset-4">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 💡 Alpine.js Logic (ကျန်ရှိမြဲ) -->
    <script>
        function checkoutForm() {
            return {
                showModal: false,
                qrCode: null,
                txId: null,
                customer_name: '{{ Auth::user()->name }}',
                phoneSuffix: '', // 09 နောက်က ရိုက်ထည့်မည့် ဂဏန်းများ
                address: '',
                errorMessage: '',
                pollInterval: null,

                // 💡 ဂဏန်းမဟုတ်တာ ရိုက်ရင် အလိုအလျောက် ဖျက်ပေးမည့် Filter
                filterPhoneInput(e) {
                    this.phoneSuffix = e.target.value.replace(/[^0-9]/g, '');
                },

                submitOrder() {
                    const fullPhone = '09' + this.phoneSuffix;

                    // ၁။ Validation စစ်ဆေးခြင်း
                    if (!this.customer_name.trim()) {
                        this.errorMessage = 'ကျေးဇူးပြု၍ နာမည် ဖြည့်ပေးပါ!';
                        return;
                    }

                    // ဖုန်းနံပါတ် စုစုပေါင်း ၈ လုံးမှ ၁၁ လုံးအတွင်း စစ်ခြင်း
                    if (fullPhone.length < 8 || fullPhone.length > 11) {
                        this.errorMessage = 'ဖုန်းနံပါတ်သည် (09) အပါအဝင် စုစုပေါင်း ၈ လုံးမှ ၁၁ လုံးအထိ ဖြစ်ရပါမည်!';
                        return;
                    }

                    if (!this.address.trim()) {
                        this.errorMessage = 'ကျေးဇူးပြု၍ လိပ်စာ အပြည့်အစုံ ဖြည့်ပေးပါ!';
                        return;
                    }

                    this.errorMessage = '';

                    // ၂။ Order Place Request
                    fetch('{{ route('checkout.placeOrder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            customer_name: this.customer_name,
                            phone: fullPhone, // 💡 "09xxxxxxxxx" အပြည့်အစုံ ပို့ပေးမည်
                            address: this.address
                        })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                this.qrCode = data.qr_code;
                                this.txId = data.order_id;
                                this.showModal = true;

                                this.checkPaymentStatus();
                            } else {
                                alert('Order တင်၍ မအောင်မြင်ပါ!');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Server Error ဖြစ်သွားပါသည်။');
                        });
                },

                checkPaymentStatus() {
                    this.pollInterval = setInterval(() => {
                        if (!this.txId || !this.showModal) return;

                        fetch('/api/check-order-status/' + this.txId)
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'paid') {
                                    clearInterval(this.pollInterval);

                                    // 💡 QR Code ပြထားသော မူရင်း Account/Browser ၏ Cart ကိုသာ Empty လုပ်မည်
                                    fetch('{{ route("cart.clear") }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json'
                                        }
                                    }).then(() => {
                                        alert('ငွေပေးချေမှု အောင်မြင်ပါသည်။');
                                        window.location.href = '/';
                                    });
                                }
                            })
                            .catch(err => console.error(err));
                    }, 2000);
                },


                closeModal() {
                    this.showModal = false;
                    if (this.pollInterval) {
                        clearInterval(this.pollInterval);
                    }
                }
            }
        }
    </script>
</x-app-layout>