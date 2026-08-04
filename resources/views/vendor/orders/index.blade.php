<x-app-layout :hideSearch="true" :cartIcon="true" :messageIcon="true" :hideRoleMenu="true" :hideDropdown="true">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="text-base font-black tracking-wide text-orange-500 dark:text-orange-400">
                {{ $vendor->shop_name }}
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 ml-1"></span>
            </h2>
        </div>
    </x-slot>

    {{-- Main Background: Dashboard ထဲကအတိုင်း Mint Green အရောင် --}}
    <div id="sidebarOverlay"
        class="fixed top-[65px] left-0 right-0 bottom-0 bg-black/40 z-30 hidden transition-opacity duration-300">
    </div>

    <!-- 💡 Sidebar Section (Dashboard Style အတိအကျ) -->
    <div id="sidebar"
        class="fixed top-[65px] left-0 h-[calc(100vh-65px)] w-64 bg-[#d1fae5] dark:bg-[#064e3b] z-30 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between overflow-y-auto border-r-4 border-[#065f46] dark:border-emerald-300">
        <div>
            <!-- Sidebar Header -->
            <div
                class="flex justify-between items-center mb-6 border-b-2 border-[#065f46] dark:border-emerald-300 pb-3">
                <h2 class="text-xl font-black text-[#065f46] dark:text-emerald-100 tracking-wider uppercase">
                    Vendor Menu
                </h2>
                <button id="closeBtn"
                    class="text-[#065f46] dark:text-emerald-200 p-1 hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links (3D Solid Block Style) -->
            <div class="space-y-3">

                <a href="{{ route('vendor.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-950 border-2 border-[#065f46] dark:border-emerald-300 text-[#065f46] dark:text-emerald-100 font-black text-sm shadow-[2px_3px_0px_0px_#065f46] dark:shadow-[2px_3px_0px_0px_#a7f3d0] hover:translate-y-[-2px] active:translate-y-[2px] transition-all">
                    <svg class="w-5 h-5 text-[#065f46] dark:text-emerald-300 stroke-[2.5]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-950 border-2 border-[#065f46] dark:border-emerald-300 text-[#065f46] dark:text-emerald-100 font-black text-sm shadow-[2px_3px_0px_0px_#065f46] dark:shadow-[2px_3px_0px_0px_#a7f3d0] hover:translate-y-[-2px] active:translate-y-[2px] transition-all">
                    <svg class="w-5 h-5 text-[#065f46] dark:text-emerald-300 stroke-[2.5]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 0118 0z"></path>
                    </svg>
                    Customer Marketplace
                </a>

                <a href="{{ route('wallet.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-950 border-2 border-[#065f46] dark:border-emerald-300 text-[#065f46] dark:text-emerald-100 font-black text-sm shadow-[2px_3px_0px_0px_#065f46] dark:shadow-[2px_3px_0px_0px_#a7f3d0] hover:translate-y-[-2px] active:translate-y-[2px] transition-all">
                    <svg class="w-5 h-5 text-[#065f46] dark:text-emerald-300 stroke-[2.5]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Wallet
                </a>

                <!-- <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-950 border-2 border-[#065f46] dark:border-emerald-300 text-[#065f46] dark:text-emerald-100 font-black text-sm shadow-[2px_3px_0px_0px_#065f46] dark:shadow-[2px_3px_0px_0px_#a7f3d0] hover:translate-y-[-2px] active:translate-y-[2px] transition-all">
                    <svg class="w-5 h-5 text-[#065f46] dark:text-emerald-300 stroke-[2.5]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    Messages
                </a> -->

                <!-- Dark Mode Toggle Button -->
                <div id="darkModeRow"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-950 border-2 border-[#065f46] dark:border-emerald-300 text-[#065f46] dark:text-emerald-100 font-black text-sm shadow-[2px_3px_0px_0px_#065f46] dark:shadow-[2px_3px_0px_0px_#a7f3d0] hover:translate-y-[-2px] active:translate-y-[2px] transition-all cursor-pointer select-none">
                    <svg id="nightModeIcon" class="w-5 h-5 text-[#065f46] stroke-[2.5] block dark:hidden" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                    <svg id="dayModeIcon" class="w-5 h-5 text-yellow-400 stroke-[2.5] hidden dark:block" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 17.657l.707.707M6.343 6.343l.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                    <span id="darkModeText">Night Mode</span>
                </div>

            </div>
        </div>

        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}" class="pt-4">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-[#ff3b68] border-2 border-[#065f46] text-white font-black text-sm text-left shadow-[2px_3px_0px_0px_#065f46] hover:translate-y-[-2px] active:translate-y-[2px] transition-all">
                <svg class="w-5 h-5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Logout
            </button>
        </form>
    </div>

    <div class="min-h-screen bg-[#d8f5e5] text-slate-800 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-8">

            {{-- Header Section --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-[#104e35] tracking-tight">
                        Shop Sales & Order Items 🛒
                    </h1>
                </div>
            </div>

            <!-- Stat Cards Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Total Items Sold Card (Paid Only) -->
                <div
                    class="p-6 rounded-2xl bg-white border-2 border-[#104e35] shadow-[4px_4px_0px_#104e35] flex items-center justify-between">
                    <div>
                        <span class="text-xs font-black uppercase tracking-wider text-[#ea580c]">Total Items Sold
                            (Paid)</span>
                        <h3 class="text-3xl font-black text-[#ea580c] mt-1">
                            {{ $paidItemsCount }} <span class="text-base font-bold text-[#104e35]">Items</span>
                        </h3>
                    </div>
                    <div
                        class="w-14 h-14 rounded-2xl bg-[#ffebd9] border-2 border-[#ea580c] flex items-center justify-center text-2xl shadow-[2px_2px_0px_#ea580c]">
                        📦
                    </div>
                </div>

                <!-- Total Net Profit Card (Paid Only) -->
                <div
                    class="p-6 rounded-2xl bg-white border-2 border-[#104e35] shadow-[4px_4px_0px_#104e35] flex items-center justify-between">
                    <div>
                        <span class="text-xs font-black uppercase tracking-wider text-[#ea580c]">Total Net Earnings
                            (98%)</span>
                        <h3 class="text-3xl font-black text-[#ea580c] mt-1">
                            {{ number_format($paidNetEarnings) }} <span
                                class="text-base font-bold text-[#104e35]">MMK</span>
                        </h3>
                    </div>
                    <div
                        class="w-14 h-14 rounded-2xl bg-[#ffebd9] border-2 border-[#ea580c] flex items-center justify-center text-2xl shadow-[2px_2px_0px_#ea580c]">
                        💰
                    </div>
                </div>
            </div>

            {{-- Order Details Section (Table / Card Banner Style) --}}
            <div
                class="bg-white rounded-2xl border-2 border-[#104e35] shadow-[5px_5px_0px_#104e35] overflow-hidden p-6 space-y-6">

                <div class="flex items-center justify-between border-b-2 border-[#104e35]/20 pb-4">
                    <h2 class="text-xl font-black text-[#104e35]">Order Items History</h2>
                    <form method="GET" action="{{ route('vendor.orders.index') }}" id="statusFilterForm">
                        <select name="status" onchange="document.getElementById('statusFilterForm').submit()"
                            class="px-3 py-1.5 bg-[#d8f5e5] text-[#104e35] border-2 border-[#104e35] rounded-xl font-bold text-xs shadow-[2px_2px_0px_#104e35] focus:ring-0 focus:border-[#104e35] cursor-pointer">
                            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>
                                Total Orders ({{ $allOrdersCount }})
                            </option>
                            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>
                                Pending ({{ $pendingOrdersCount }})
                            </option>
                            <option value="paid" {{ $status === 'paid' ? 'selected' : '' }}>
                                Paid ({{ $paidOrdersCount }})
                            </option>
                        </select>
                    </form>
                </div>

                <div class="space-y-4">
                    @forelse($myOrders as $item)
                        @php
                            $itemTotal = $item->price * $item->quantity;
                            $netEarning = $item->vendor_amount > 0 ? $item->vendor_amount : ($itemTotal * 0.98);
                        @endphp

                        <div
                            class="p-5 rounded-2xl bg-[#f7fdfa] border-2 border-[#104e35] shadow-[3px_3px_0px_#104e35] flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:bg-white transition-all">

                            {{-- Product & Order Details --}}
                            <div class="space-y-2 flex-1">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2.5 py-1 bg-[#ea580c] text-white rounded-lg font-black text-[10px] tracking-wider border border-[#104e35]">
                                        INVOICE #{{ $item->order->id ?? 'N/A' }}
                                    </span>
                                    <span class="text-xs font-bold text-[#2d6a4f]">
                                        📅 {{ $item->created_at->format('d M Y, h:i A') }}
                                    </span>
                                </div>

                                <div>
                                    <h3 class="text-lg font-black text-[#104e35]">
                                        {{ $item->product->name ?? 'Product Deleted' }}
                                    </h3>
                                    <p class="text-xs font-bold text-slate-600 mt-0.5">
                                        Quantity: <span class="text-[#ea580c] font-black">{{ $item->quantity }}</span> |
                                        Unit Price: <span
                                            class="text-[#104e35] font-black">{{ number_format($item->price) }} MMK</span>
                                        @if($item->color || $item->size)
                                            <span
                                                class="ml-1 text-[#ea580c] bg-[#ffebd9] px-2 py-0.5 rounded-md border border-[#ea580c]/40 font-bold">
                                                ({{ implode(' ', array_filter([$item->color, $item->size ? '[' . $item->size . ']' : ''])) }})
                                            </span>
                                        @endif
                                    </p>
                                </div>

                                {{-- Customer Info --}}
                                <div class="pt-2 border-t border-[#104e35]/10 flex items-start gap-2 text-xs">
                                    <span class="text-base">📍</span>
                                    <div>
                                        <span
                                            class="font-black text-[#104e35]">{{ $item->order->customer_name ?? 'Unknown Customer' }}</span>
                                        <span
                                            class="text-slate-500 font-bold">({{ $item->order->customer_phone ?? 'No Phone' }})</span>
                                        <div class="text-slate-600 font-semibold mt-0.5">
                                            {{ $item->order->shipping_address ?? 'No shipping address provided.' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Earnings & Status Side --}}
                            <div
                                class="w-full md:w-auto flex md:flex-col justify-between md:justify-center items-center md:items-end border-t md:border-t-0 pt-3 md:pt-0 border-[#104e35]/10 gap-2 shrink-0">
                                <div>
                                    @if(($item->order->status ?? '') === 'paid')
                                        <span
                                            class="btn-3d text-[11px] font-black text-emerald-300 bg-emerald-900/80 border border-emerald-500 px-3 py-1.5 rounded-xl">
                                            ● Paid
                                        </span>
                                    @else
                                        <span
                                            class="btn-3d text-[11px] font-black text-emerald-300 bg-emerald-900/80 border border-emerald-500 px-3 py-1.5 rounded-xl">
                                            ● Pending
                                        </span>
                                    @endif
                                </div>

                                <div class="text-right">
                                    <span class="text-[10px] font-black text-slate-500 block uppercase tracking-wider">Your
                                        Net Earning</span>
                                    <span class="text-xl font-black text-[#ea580c]">
                                        {{ number_format($netEarning) }} MMK
                                    </span>
                                    <span class="block text-[9px] font-bold text-[#2d6a4f]">(2% Commission Deducted)</span>
                                </div>
                            </div>

                        </div>
                    @empty
                        <div
                            class="p-10 text-center rounded-2xl bg-[#d8f5e5]/40 border-2 border-dashed border-[#104e35]/40 text-[#104e35]">
                            <div class="text-4xl mb-2">🍃</div>
                            <h3 class="text-base font-black">There are no sales records yet.</h3>
                        </div>
                    @endforelse
                </div>

            </div>

        </div>
    </div>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const closeBtn = document.getElementById('closeBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const darkModeRow = document.getElementById('darkModeRow');
        const darkModeText = document.getElementById('darkModeText');

        function updateTheme(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                if (darkModeText) darkModeText.innerText = 'Day Mode';
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                if (darkModeText) darkModeText.innerText = 'Night Mode';
            }
        }

        // Initial Load Check
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            updateTheme(true);
        } else {
            updateTheme(false);
        }

        // Click Event Listener
        if (darkModeRow) {
            darkModeRow.addEventListener('click', () => {
                const isCurrentlyDark = document.documentElement.classList.contains('dark');
                updateTheme(!isCurrentlyDark);
            });
        }

        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
            });
        }
        const closeSidebar = () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        };
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);
    </script>
</x-app-layout>