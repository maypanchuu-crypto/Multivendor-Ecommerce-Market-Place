<section>
    <header class="flex items-center gap-3 border-b border-white/20 pb-4 mb-6">
        <div class="p-2.5 rounded-xl bg-white/20 text-white backdrop-blur-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                </path>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-black text-white tracking-tight">Profile Information</h2>
            <p class="text-xs text-orange-100 font-medium">Update your account's profile information and email address.
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name"
                class="block text-xs font-bold uppercase tracking-wider text-orange-100 mb-1.5">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus
                autocomplete="name"
                class="w-full px-4 py-3 rounded-xl bg-white text-slate-800 font-semibold text-sm focus:ring-2 focus:ring-amber-300 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.1)]">
            <x-input-error class="mt-1.5 text-xs text-yellow-200 font-bold" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email"
                class="block text-xs font-bold uppercase tracking-wider text-orange-100 mb-1.5">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                autocomplete="username"
                class="w-full px-4 py-3 rounded-xl bg-white text-slate-800 font-semibold text-sm focus:ring-2 focus:ring-amber-300 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.1)]">
            <x-input-error class="mt-1.5 text-xs text-yellow-200 font-bold" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-white/20 border border-white/30 rounded-xl text-xs text-white">
                    <p>
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline font-black hover:text-orange-200">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1.5 font-bold text-yellow-200">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="pt-2 flex items-center gap-4">
            <button type="submit"
                class="bg-slate-900 hover:bg-slate-800 text-white font-black py-3.5 px-6 rounded-xl text-xs uppercase tracking-wider shadow-[0_5px_0_0_#0f172a] active:translate-y-1 active:shadow-none transition-all duration-150">
                Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-bold text-yellow-200 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Saved successfully.
                </p>
            @endif
        </div>
    </form>
</section>