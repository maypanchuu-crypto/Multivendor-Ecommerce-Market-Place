<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Wallet Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Alert Messages --}}
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- ၁။ Wallet ရှိပြီးသားဆိုလျှင် Amount ပြမည် --}}
                @if ($wallet)
                    <div class="text-center py-8">
                        <div class="inline-block bg-amber-500/10 dark:bg-amber-500/20 p-4 rounded-full mb-4">
                            <svg class="w-16 h-16 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-gray-500 dark:text-gray-400 text-lg font-medium">Wallet Balance</h3>
                        <p class="text-4xl font-extrabold text-amber-500 mt-2">
                            {{ number_format($wallet->balance, 2) }} <span class="text-2xl font-normal">MMK</span>
                        </p>

                        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Account Owner: <span
                                    class="font-semibold text-gray-800 dark:text-gray-200">{{ $user->name }}</span></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Email: <span
                                    class="font-semibold text-gray-800 dark:text-gray-200">{{ $user->email }}</span></p>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('wallet.password.edit') }}"
                                class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                Change Wallet Password
                            </a>
                        </div>
                    </div>

                    {{-- ၂။ Wallet မရှိသေးလျှင် Create Wallet Form ပြပေးမည် --}}
                @else
                    <div class="max-w-md mx-auto">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2 text-center">Create Wallet
                            Account</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
                            Open a wallet account to receive a starting bonus of <span
                                class="font-bold text-amber-500">2,000,000 MMK</span>!
                        </p>

                        <form action="{{ route('wallet.store') }}" method="POST">
                            @csrf

                            <!-- Account Name (Logged in user name - Readonly) -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Account
                                    Name</label>
                                <input type="text" value="{{ $user->name }}" readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300 cursor-not-allowed">
                            </div>

                            <!-- Wallet Password -->
                            <div class="mb-4">
                                <label for="wallet_password"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Wallet
                                    Password</label>
                                <input type="password" name="wallet_password" id="wallet_password" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500">
                                @error('wallet_password')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirm Wallet Password -->
                            <div class="mb-6">
                                <label for="wallet_password_confirmation"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Confirm Wallet
                                    Password</label>
                                <input type="password" name="wallet_password_confirmation" id="wallet_password_confirmation"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <button type="submit"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-2.5 px-4 rounded-lg transition duration-200 shadow-md">
                                Create Account
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>