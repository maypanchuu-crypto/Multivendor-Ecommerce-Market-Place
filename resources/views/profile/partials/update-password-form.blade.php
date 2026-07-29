<section>
    <header class="flex items-center gap-3 border-b border-white/20 pb-4 mb-6">
        <div class="p-2.5 rounded-xl bg-white/20 text-white backdrop-blur-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                </path>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-black text-white tracking-tight">Update Password</h2>
            <p class="text-xs text-orange-100 font-medium">Ensure your account is using a long, random password to stay
                secure.</p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password"
                class="block text-xs font-bold uppercase tracking-wider text-orange-100 mb-1.5">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password"
                autocomplete="current-password" placeholder="••••••••"
                class="w-full px-4 py-3 rounded-xl bg-white text-slate-800 font-semibold text-sm focus:ring-2 focus:ring-amber-300 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.1)]">
            <x-input-error :messages="$errors->updatePassword->get('current_password')"
                class="mt-1.5 text-xs text-yellow-200 font-bold" />
        </div>

        <div>
            <label for="update_password_password"
                class="block text-xs font-bold uppercase tracking-wider text-orange-100 mb-1.5">New Password</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                placeholder="••••••••"
                class="w-full px-4 py-3 rounded-xl bg-white text-slate-800 font-semibold text-sm focus:ring-2 focus:ring-amber-300 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.1)]">
            <x-input-error :messages="$errors->updatePassword->get('password')"
                class="mt-1.5 text-xs text-yellow-200 font-bold" />
        </div>

        <div>
            <label for="update_password_password_confirmation"
                class="block text-xs font-bold uppercase tracking-wider text-orange-100 mb-1.5">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                autocomplete="new-password" placeholder="••••••••"
                class="w-full px-4 py-3 rounded-xl bg-white text-slate-800 font-semibold text-sm focus:ring-2 focus:ring-amber-300 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.1)]">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-1.5 text-xs text-yellow-200 font-bold" />
        </div>

        <div class="pt-2 flex items-center gap-4">
            <button type="submit"
                class="bg-slate-900 hover:bg-slate-800 text-white font-black py-3.5 px-6 rounded-xl text-xs uppercase tracking-wider shadow-[0_5px_0_0_#0f172a] active:translate-y-1 active:shadow-none transition-all duration-150">
                Update Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-bold text-yellow-200 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Updated successfully.
                </p>
            @endif
        </div>
    </form>
</section>