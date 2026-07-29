<x-app-layout :hideSearch="true" :cartIcon="true" :messageIcon="true" :hideRoleMenu="true" :hideDropdown="true">

    <div id="sidebarOverlay"
        class="fixed top-[65px] left-0 right-0 bottom-0 bg-black/40 z-30 hidden transition-opacity duration-300">
    </div>

    <!-- 💡 Sidebar Section (3D Styled) -->
    <div id="sidebar"
        class="fixed top-[65px] left-0 h-[calc(100vh-65px)] w-64 bg-white dark:bg-gray-800 z-30 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between overflow-y-auto border-r-4 border-emerald-800 dark:border-emerald-300">
        <div>
            <div
                class="flex justify-between items-center mb-6 border-b-2 border-emerald-800 dark:border-emerald-300 pb-3">
                <h2 class="text-xl font-black text-emerald-950 dark:text-emerald-100 tracking-wider uppercase">
                    Vendor Menu</h2>
                <button id="closeBtn"
                    class="text-emerald-800 dark:text-emerald-200 p-1 hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="space-y-3">
                <a href="{{ route('dashboard') }}"
                    class="btn-3d flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-900 text-emerald-950 dark:text-emerald-100 font-black text-sm">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-300 stroke-[2.5]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 0118 0z"></path>
                    </svg>
                    Customer Marketplace
                </a>

                <a href="{{ route('vendor.orders.index') }}"
                    class="btn-3d flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-900 text-emerald-950 dark:text-emerald-100 font-black text-sm">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-300 stroke-[2.5]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    My Shop Orders
                </a>

                <a href="#"
                    class="btn-3d flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-900 text-emerald-950 dark:text-emerald-100 font-black text-sm">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-300 stroke-[2.5]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Wallet
                </a>

                <a href="#"
                    class="btn-3d flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-900 text-emerald-950 dark:text-emerald-100 font-black text-sm">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-300 stroke-[2.5]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    Messages
                </a>

                <!-- 💡 Dark Mode Switch (navigation.blade.php ပုံစံအတိုင်း ပြင်ဆင်ထားပါသည်) -->
                <div id="darkModeRow"
                    class="btn-3d flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-900 text-emerald-950 dark:text-emerald-100 font-black text-sm cursor-pointer select-none">

                    <!-- 🌙 Night Mode Icon (Light mode မှာပဲ ပြမည်) -->
                    <svg id="nightModeIcon" class="w-5 h-5 text-emerald-600 stroke-[2.5] block dark:hidden" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>

                    <!-- ☀️ Day Mode Icon (Dark mode မှာပဲ ပြမည်) -->
                    <svg id="dayModeIcon" class="w-5 h-5 text-yellow-400 stroke-[2.5] hidden dark:block" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 17.657l.707.707M6.343 6.343l.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>

                    <!-- 📝 Dynamic Text (JavaScript မှ Control လုပ်မည်) -->
                    <span id="darkModeText" class="tracking-wide">Night Mode</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="pt-4">
            @csrf
            <button type="submit"
                class="btn-3d w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-rose-500 text-white font-black text-sm text-left shadow-none">
                <svg class="w-5 h-5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Logout
            </button>
        </form>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-1 space-y-6">
                <div class="bg-blue-600 text-white p-6 rounded-2xl shadow-xl">
                    <h3 class="text-sm font-bold opacity-80 uppercase">My Wallet Balance</h3>
                    <div class="text-3xl font-black mt-2">{{ number_format($vendor->balance) }} MMK</div>
                </div>

                <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-md border dark:border-gray-800">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">Request Money
                    </h3>
                    <form action="{{ route('vendor.withdraw.submit') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Amount
                                (withdraw amount)</label>
                            <input type="number" name="amount" min="1000" max="{{ $vendor->balance }}"
                                class="w-full px-3 py-2 border rounded-xl dark:bg-gray-800 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Payment Method</label>
                            <select name="payment_method"
                                class="w-full px-3 py-2 border rounded-xl dark:bg-gray-800 dark:text-white">
                                <option value="KPay">KBZPay</option>
                                <option value="WaveMoney">Wave Money</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Account Number</label>
                            <input type="text" name="account_number"
                                class="w-full px-3 py-2 border rounded-xl dark:bg-gray-800 dark:text-white"
                                placeholder="09xxxxxxxxx" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Account Name</label>
                            <input type="text" name="account_name"
                                class="w-full px-3 py-2 border rounded-xl dark:bg-gray-800 dark:text-white" required>
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white font-bold py-2.5 rounded-xl shadow-md">Submit
                            Request</button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-md border dark:border-gray-800 h-full">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">Withdrawal History</h3>
                    <div class="space-y-3 overflow-y-auto max-h-[500px]">
                        @forelse($history as $item)
                            <div
                                class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border dark:border-gray-800">
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">{{ number_format($item->amount) }}
                                        MMK</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ $item->payment_method }} •
                                        {{ $item->created_at->format('d M Y h:i A') }}
                                    </div>
                                    @if($item->admin_note)
                                        <div class="text-xs text-rose-500 mt-1 font-medium">Reason: {{ $item->admin_note }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    @if($item->status === 'pending')
                                        <span
                                            class="text-xs font-bold px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                    @elseif($item->status === 'approved')
                                        <span
                                            class="text-xs font-bold px-2.5 py-1 bg-green-100 text-green-800 rounded-full">Success</span>
                                    @else
                                        <span
                                            class="text-xs font-bold px-2.5 py-1 bg-rose-100 text-rose-800 rounded-full">Rejected</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400">No withdrawal history yet</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>