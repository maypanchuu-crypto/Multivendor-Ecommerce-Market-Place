<x-app-layout :hideNav="true">
    <div
        class="min-h-screen bg-slate-50 py-10 px-4 sm:px-6 lg:px-8 flex items-center justify-center font-sans antialiased selection:bg-emerald-500 selection:text-white">
        <div class="w-full max-w-lg mx-auto">

            {{-- 3D Card Wrapper --}}
            <div
                class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.07)]">

                {{-- Card Header --}}
                <div class="flex items-center gap-4 mb-8 border-b border-slate-100 pb-5">
                    <div
                        class="p-3.5 rounded-2xl bg-gradient-to-tr from-emerald-600 to-emerald-500 text-white shadow-[0_8px_16px_rgba(16,185,129,0.25),inset_0_2px_4px_rgba(255,255,255,0.3)]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-800 tracking-tight">Change 6-Digit PIN</h2>
                        <p class="text-xs text-slate-500 font-medium">Update your secure wallet passcode</p>
                    </div>
                </div>

                <!-- Success Alert -->
                @if (session('status'))
                    <div
                        class="p-4 mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-2xl flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <form action="{{ route('wallet.password.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Current 6-Digit PIN -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Current
                            6-Digit PIN</label>
                        <input type="password" name="current_password" required maxlength="6" pattern="\d{6}"
                            inputmode="numeric" placeholder="••••••"
                            class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 text-lg tracking-widest placeholder-slate-300 focus:bg-white focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 transition-all duration-200 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] text-center">
                        @error('current_password')
                            <span class="text-xs text-rose-500 font-semibold mt-1.5 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- New 6-Digit PIN -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">New 6-Digit
                            PIN</label>
                        <input type="password" name="new_password" required maxlength="6" pattern="\d{6}"
                            inputmode="numeric" placeholder="••••••"
                            class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 text-lg tracking-widest placeholder-slate-300 focus:bg-white focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 transition-all duration-200 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] text-center">
                        @error('new_password')
                            <span class="text-xs text-rose-500 font-semibold mt-1.5 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm New 6-Digit PIN -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Confirm New
                            6-Digit PIN</label>
                        <input type="password" name="new_password_confirmation" required maxlength="6" pattern="\d{6}"
                            inputmode="numeric" placeholder="••••••"
                            class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 text-lg tracking-widest placeholder-slate-300 focus:bg-white focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 transition-all duration-200 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.03)] text-center">
                    </div>

                    <!-- 3D Push Button -->
                    <div class="pt-4 flex items-center gap-3">
                        <a href="{{ route('wallet.index') }}"
                            class="w-1/3 text-center py-3.5 px-4 rounded-xl text-xs uppercase tracking-wider font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 border border-slate-200 shadow-[0_4px_0_0_#e2e8f0] active:translate-y-0.5 active:shadow-[0_1px_0_0_#e2e8f0] transition-all duration-150">
                            Cancel
                        </a>

                        <button type="submit"
                            class="w-2/3 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-black py-3.5 px-4 rounded-xl text-xs uppercase tracking-wider shadow-[0_6px_0_0_#047857,0_10px_20px_rgba(16,185,129,0.2)] active:translate-y-1 active:shadow-[0_2px_0_0_#047857,0_5px_10px_rgba(16,185,129,0.2)] transition-all duration-150">
                            Update PIN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>