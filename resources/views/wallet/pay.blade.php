<x-app-layout :hideNav="true">
    <div class="min-h-screen bg-slate-100 flex items-center justify-center p-4">
        <div class="bg-white max-w-md w-full rounded-3xl p-6 shadow-xl border border-slate-200 text-center">

            <div
                class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </div>

            <h2 class="text-xl font-black text-slate-800">Confirm Payment</h2>
            <p class="text-xs font-semibold text-slate-400 mt-1 mb-6">Enter password to confirm order</p>

            <!-- Order Summary Info Box -->
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 mb-6 text-left space-y-2">
                <div class="flex justify-between text-xs text-slate-500 font-bold">
                    <span>Total Balance:</span>
                    <span class="text-slate-800 font-black">
                        {{ isset($wallet) ? number_format($wallet->balance) . ' MMK' : 'Wallet not found' }}
                    </span>
                </div>
                <div class="flex justify-between text-xs text-slate-500 font-bold">
                    <span>Total Amount:</span>
                    <span class="text-emerald-600 text-base font-black">{{ number_format($order->total_amount) }}
                        MMK</span>
                </div>
            </div>

            <!-- Error Alert Message -->
            @if(session('error'))
                <div
                    class="p-3 mb-4 bg-rose-50 border border-rose-200 text-rose-600 text-xs font-bold rounded-xl text-left">
                    {{ session('error') }}
                </div>
            @endif

            <!-- 6-Digit Password Form -->
            <form action="{{ route('wallet.pay.process', $order->id) }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wider text-left">
                        Wallet Password *
                    </label>
                    <input type="password" name="wallet_password" maxlength="6" pattern="[0-9]*" inputmode="numeric"
                        required
                        class="w-full text-center tracking-[1em] text-2xl font-black border-2 border-slate-200 focus:border-emerald-500 rounded-2xl p-3 outline-none transition bg-slate-50"
                        placeholder="••••••">
                    <!-- <p class="text-[10px] text-slate-400 mt-1 text-left">* Default password is 123456</p> -->
                </div>

                <button type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-black py-3.5 rounded-2xl shadow-lg shadow-emerald-600/30 transition text-sm">
                    Confirm
                </button>
            </form>

        </div>
    </div>
</x-app-layout>