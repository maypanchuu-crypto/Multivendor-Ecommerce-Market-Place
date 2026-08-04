<x-app-layout :hideNav="true">
    <div
        class="min-h-screen bg-slate-50 py-10 px-4 sm:px-6 lg:px-8 flex items-center justify-center font-sans antialiased selection:bg-amber-500 selection:text-white">
        <div class="w-full max-w-xl mx-auto">

            {{-- Flash Alert Messages --}}
            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold shadow-xs flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('status'))
                <div
                    class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-sm font-semibold shadow-xs flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- 3D Container Box (White Theme) --}}
            <div
                class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.07)]">

                {{-- ၁။ Wallet ရှိပြီးသားဆိုလျှင် Display ပြမည် --}}
                @if ($wallet)
                    <div class="text-center space-y-6">

                        {{-- 3D Credit Card --}}
                        <div class="relative transform transition-all duration-500 hover:scale-[1.01]">
                            <div
                                class="w-full bg-gradient-to-br from-amber-500 via-amber-600 to-amber-700 rounded-2xl p-6 sm:p-8 text-left text-white shadow-[0_15px_30px_rgba(245,158,11,0.25)] border border-amber-300/30 relative overflow-hidden">

                                <div
                                    class="absolute -top-24 -right-24 w-48 h-48 bg-white/20 rounded-full blur-2xl pointer-events-none">
                                </div>

                                <div class="flex justify-between items-start mb-8">
                                    <div>
                                        <p class="text-xs uppercase tracking-widest text-amber-100 font-bold">Digital Wallet
                                            Pass</p>
                                        <h4 class="text-lg font-black tracking-wider text-white mt-0.5">PAYMENT CARD</h4>
                                    </div>
                                    <div
                                        class="w-12 h-9 rounded-lg bg-gradient-to-br from-amber-200 to-yellow-400 border border-amber-100 shadow-xs relative flex items-center justify-center">
                                        <div class="w-full h-[1px] bg-amber-700/40 absolute top-3"></div>
                                        <div class="w-full h-[1px] bg-amber-700/40 absolute bottom-3"></div>
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <p class="text-xs text-amber-100 font-medium">Available Balance</p>
                                    <div class="flex items-baseline gap-2 mt-1">
                                        <span class="text-3xl sm:text-4xl font-extrabold tracking-tight drop-shadow-xs">
                                            {{ number_format($wallet->balance, 2) }}
                                        </span>
                                        <span class="text-sm sm:text-base font-bold text-amber-100">MMK</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-end border-t border-amber-400/30 pt-4">
                                    <div>
                                        <p class="text-[10px] uppercase text-amber-100 font-semibold">Account Owner</p>
                                        <p class="text-sm font-bold text-white uppercase mt-0.5">{{ $user->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] uppercase text-amber-100 font-semibold">Contact Email</p>
                                        <p class="text-xs font-medium text-amber-100 mt-0.5">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 3D Action Button --}}
                        <div class="pt-4">
                            <a href="{{ route('wallet.password.edit') }}"
                                class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3.5 rounded-xl font-bold text-sm text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 shadow-[0_5px_0_0_#e2e8f0] active:translate-y-1 active:shadow-[0_2px_0_0_#e2e8f0] transition-all duration-150">
                                <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Change Wallet Password
                            </a>
                        </div>
                    </div>

                    {{-- ၂။ Create Wallet Form (White Theme) --}}
                @else
                    <div class="max-w-md mx-auto">
                        <div class="text-center mb-6">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-amber-500 to-amber-400 text-white shadow-[0_8px_20px_rgba(245,158,11,0.25)] mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Create Wallet Account</h3>
                            <p class="text-xs text-slate-500 mt-1">
                                Open an account & get a starting bonus of <span class="font-bold text-amber-600">2,000,000
                                    MMK</span>
                            </p>
                        </div>

                        <form action="{{ route('wallet.store') }}" method="POST" class="space-y-5">
                            @csrf

                            <div>
                                <label
                                    class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Account
                                    Owner</label>
                                <input type="text" value="{{ $user->name }}" readonly
                                    class="w-full px-4 py-3.5 rounded-xl bg-slate-100 border border-slate-200 text-slate-500 text-sm font-semibold cursor-not-allowed focus:outline-none">
                            </div>

                            <div>
                                <label for="wallet_password"
                                    class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Wallet
                                    Password (6-Digit PIN)</label>
                                <input type="password" name="wallet_password" id="wallet_password" required maxlength="6"
                                    pattern="[0-9]{6}" inputmode="numeric" placeholder="••••••"
                                    class="w-full px-4 py-4 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 text-center text-lg tracking-[0.5em] placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all duration-200 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)]">
                                @error('wallet_password')
                                    <span class="text-xs text-rose-500 font-semibold mt-1.5 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="wallet_password_confirmation"
                                    class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Confirm
                                    Password</label>
                                <input type="password" name="wallet_password_confirmation" id="wallet_password_confirmation"
                                    required maxlength="6" pattern="[0-9]{6}" inputmode="numeric" placeholder="••••••"
                                    class="w-full px-4 py-4 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 text-center text-lg tracking-[0.5em] placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all duration-200 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)]">
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-white font-black py-3.5 px-4 rounded-xl text-sm uppercase tracking-wider shadow-[0_6px_0_0_#b45309,0_10px_20px_rgba(245,158,11,0.2)] active:translate-y-1 active:shadow-[0_2px_0_0_#b45309,0_5px_10px_rgba(245,158,11,0.2)] transition-all duration-150">
                                    Create Account
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>