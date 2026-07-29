<x-app-layout :hideNav="true">
    <div
        class="min-h-screen bg-slate-50 py-10 px-4 sm:px-6 lg:px-8 flex items-center justify-center font-sans antialiased selection:bg-amber-500 selection:text-white">
        <div class="w-full max-w-lg mx-auto">

            {{-- 3D Card Wrapper (Index Card Gradient Color) --}}
            <div
                class="relative bg-gradient-to-br from-amber-500 via-amber-600 to-amber-700 rounded-3xl p-6 sm:p-10 text-white shadow-[0_20px_40px_rgba(245,158,11,0.25)] border border-amber-300/30 overflow-hidden">

                {{-- Glowing Backdrop Effect --}}
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-white/20 rounded-full blur-2xl pointer-events-none">
                </div>

                {{-- Card Header --}}
                <div class="flex items-center gap-4 mb-8 border-b border-amber-400/30 pb-5 relative z-10">
                    <div
                        class="p-3.5 rounded-2xl bg-white/20 text-white backdrop-blur-md shadow-xs border border-white/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-white tracking-tight drop-shadow-xs">Change 6-Digit PIN</h2>
                        <p class="text-xs text-amber-100 font-medium">Update your secure wallet passcode</p>
                    </div>
                </div>

                <!-- Success Alert -->
                @if (session('status'))
                    <div
                        class="p-4 mb-6 bg-white/20 border border-white/30 text-white text-sm font-semibold rounded-2xl flex items-center gap-2.5 backdrop-blur-md relative z-10">
                        <svg class="w-5 h-5 text-amber-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <form action="{{ route('wallet.password.update') }}" method="POST" class="space-y-6 relative z-10">
                    @csrf
                    @method('PUT')

                    <!-- Current 6-Digit PIN -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-amber-100 mb-2">Current
                            6-Digit PIN</label>
                        <input type="password" name="current_password" required maxlength="6" pattern="\d{6}"
                            inputmode="numeric" placeholder="••••••"
                            class="w-full px-4 py-3.5 rounded-xl bg-white text-slate-800 font-semibold text-lg tracking-widest placeholder-slate-400 focus:ring-2 focus:ring-amber-200 transition-all duration-200 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.1)] text-center">
                        @error('current_password')
                            <span class="text-xs text-yellow-200 font-bold mt-1.5 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- New 6-Digit PIN -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-amber-100 mb-2">New 6-Digit
                            PIN</label>
                        <input type="password" name="new_password" required maxlength="6" pattern="\d{6}"
                            inputmode="numeric" placeholder="••••••"
                            class="w-full px-4 py-3.5 rounded-xl bg-white text-slate-800 font-semibold text-lg tracking-widest placeholder-slate-400 focus:ring-2 focus:ring-amber-200 transition-all duration-200 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.1)] text-center">
                        @error('new_password')
                            <span class="text-xs text-yellow-200 font-bold mt-1.5 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm New 6-Digit PIN -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-amber-100 mb-2">Confirm New
                            6-Digit PIN</label>
                        <input type="password" name="new_password_confirmation" required maxlength="6" pattern="\d{6}"
                            inputmode="numeric" placeholder="••••••"
                            class="w-full px-4 py-3.5 rounded-xl bg-white text-slate-800 font-semibold text-lg tracking-widest placeholder-slate-400 focus:ring-2 focus:ring-amber-200 transition-all duration-200 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.1)] text-center">
                    </div>

                    <!-- 3D Push Button -->
                    <div class="pt-4 flex items-center gap-3">
                        <a href="{{ route('wallet.index') }}"
                            class="w-1/3 text-center py-3.5 px-4 rounded-xl text-xs uppercase tracking-wider font-bold text-white bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-md shadow-[0_4px_0_0_rgba(255,255,255,0.2)] active:translate-y-0.5 transition-all duration-150">
                            Cancel
                        </a>

                        <button type="submit"
                            class="w-2/3 bg-slate-900 hover:bg-slate-800 text-white font-black py-3.5 px-4 rounded-xl text-xs uppercase tracking-wider shadow-[0_6px_0_0_#0f172a,0_10px_20px_rgba(0,0,0,0.2)] active:translate-y-1 active:shadow-[0_2px_0_0_#0f172a] transition-all duration-150">
                            Update PIN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>