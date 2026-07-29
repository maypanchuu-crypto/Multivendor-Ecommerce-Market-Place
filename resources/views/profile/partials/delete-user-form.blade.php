<section class="space-y-6">
    <header class="flex items-center gap-3 border-b border-white/20 pb-4">
        <div class="p-2.5 rounded-xl bg-white/20 text-white backdrop-blur-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                </path>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-black text-white tracking-tight">Delete Account</h2>
            <p class="text-xs text-rose-100 font-medium">Once your account is deleted, all resources and data will be
                permanently purged.</p>
        </div>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-slate-900 hover:bg-slate-800 text-white font-black py-3.5 px-6 rounded-xl text-xs uppercase tracking-wider shadow-[0_5px_0_0_#0f172a] active:translate-y-1 active:shadow-none transition-all duration-150">
        Delete Account
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}"
            class="p-6 sm:p-8 bg-gradient-to-br from-rose-700 via-orange-600 to-rose-600 text-white rounded-3xl">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black tracking-tight">
                Are you sure you want to delete your account?
            </h2>

            <p class="mt-2 text-xs text-orange-100 leading-relaxed">
                Once your account is deleted, all of its resources and data will be permanently deleted. Please enter
                your password to confirm.
            </p>

            <div class="mt-6">
                <input id="password" name="password" type="password" placeholder="Enter your password to confirm"
                    class="w-full sm:w-3/4 px-4 py-3 rounded-xl bg-white text-slate-800 font-semibold text-sm focus:ring-2 focus:ring-amber-300 focus:outline-none shadow-[inset_0_2px_4px_rgba(0,0,0,0.1)]">
                <x-input-error :messages="$errors->userDeletion->get('password')"
                    class="mt-1.5 text-xs text-yellow-200 font-bold" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="py-3 px-5 rounded-xl text-xs font-bold text-white bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-md transition-all">
                    Cancel
                </button>

                <button type="submit"
                    class="bg-slate-900 hover:bg-slate-800 text-white font-black py-3 px-5 rounded-xl text-xs uppercase tracking-wider shadow-[0_4px_0_0_#0f172a] active:translate-y-0.5 transition-all">
                    Confirm Delete
                </button>
            </div>
        </form>
    </x-modal>
</section>