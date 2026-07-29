<x-app-layout :hideNav="true">
    <div
        class="min-h-screen bg-slate-50 py-10 px-4 sm:px-6 lg:px-8 font-sans antialiased selection:bg-orange-600 selection:text-white">
        <div class="max-w-4xl mx-auto space-y-8">

            {{-- Header Title --}}
            <div
                class="flex items-center justify-between bg-gradient-to-r from-orange-600 via-orange-500 to-rose-600 rounded-3xl p-6 text-white shadow-[0_15px_30px_rgba(234,88,12,0.25)] border border-orange-400/30">
                <div>
                    <h2 class="text-2xl font-black tracking-tight drop-shadow-xs">Account Settings</h2>
                    <p class="text-xs text-orange-100 font-medium mt-0.5">Manage your personal information, password,
                        and account security.</p>
                </div>
                <div class="p-3 rounded-2xl bg-white/20 text-white backdrop-blur-md shadow-xs border border-white/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>

            {{-- 1. Profile Information Card (လိမ္မော်နီရောင်) --}}
            <div
                class="bg-gradient-to-br from-orange-600 via-orange-500 to-rose-600 rounded-3xl p-6 sm:p-8 text-white shadow-[0_20px_40px_rgba(234,88,12,0.2)] border border-orange-400/30">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- 2. Password Update Card (လိမ္မော်နီရောင်) --}}
            <div
                class="bg-gradient-to-br from-orange-600 via-orange-500 to-rose-600 rounded-3xl p-6 sm:p-8 text-white shadow-[0_20px_40px_rgba(234,88,12,0.2)] border border-orange-400/30">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- 3. Delete Account Card (လိမ္မော်နီရောင်) --}}
            <div
                class="bg-gradient-to-br from-rose-700 via-orange-600 to-rose-600 rounded-3xl p-6 sm:p-8 text-white shadow-[0_20px_40px_rgba(225,29,72,0.25)] border border-rose-400/30">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>