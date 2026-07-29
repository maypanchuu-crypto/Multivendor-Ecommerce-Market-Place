<x-app-layout :hideSearch="true" :cartIcon="true" :messageIcon="true" :hideRoleMenu="true" :hideDarkMode="true">
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order & Commission Management</title>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
            }
        </script>
        <style>
            html,
            body {
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            [x-cloak] {
                display: none !important;
            }

            /* ✨ 3D Shadows & Neumorphic Effects */
            .card-3d {
                background: linear-gradient(145deg, #1e3a8a, #1e40af);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4),
                    0 8px 10px -6px rgba(0, 0, 0, 0.3),
                    inset 0 1px 1px rgba(255, 255, 255, 0.2);
                border-bottom: 4px solid #172554;
            }

            .btn-3d {
                box-shadow: 0 4px 0px #1e3a8a, 0 6px 12px rgba(0, 0, 0, 0.3);
                transition: all 0.1s ease;
            }

            .btn-3d:active {
                transform: translateY(3px);
                box-shadow: 0 1px 0px #1e3a8a, 0 2px 4px rgba(0, 0, 0, 0.3);
            }
        </style>
    </head>

    <body class="bg-blue-600 text-white min-h-screen font-sans antialiased pt-16">

        <!-- Sidebar Overlay -->
        <div id="sidebarOverlay"
            class="fixed top-16 inset-x-0 bottom-0 bg-blue-950/60 backdrop-blur-sm z-30 hidden transition-opacity duration-300">
        </div>

        <!-- Sidebar Navigation Menu -->
        <div id="sidebar"
            class="fixed top-16 left-0 h-[calc(100vh-4rem)] w-64 bg-blue-900 z-40 shadow-2xl border-r-4 border-blue-950 border-t border-blue-800 transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between overflow-y-auto">
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-black tracking-wider text-yellow-400 drop-shadow">ADMIN MENU</h2>
                    <button id="closeBtn" class="text-blue-200 hover:text-white p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('admin.dashboard') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('dashboard') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 0118 0z"></path>
                        </svg>
                        Customer Marketplace
                    </a>

                    <a href="{{ route('admin.vendor.requests') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Vendor Requests
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        User Management
                    </a>

                    <div id="darkModeRow"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm cursor-pointer border border-blue-700 select-none transform transition duration-200 hover:-translate-y-1">
                        <svg id="nightModeIcon" class="w-5 h-5 text-yellow-400 block dark:hidden" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                        <svg id="dayModeIcon" class="w-5 h-5 text-amber-400 hidden dark:block" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 17.657l.707.707M6.343 6.343l.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                        <span id="darkModeText" class="tracking-wide">Night Mode</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="border-t border-blue-800 pt-4">
                @csrf
                <button type="submit"
                    class="btn-3d w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-rose-600 text-white font-medium text-sm text-left border border-rose-700 transform transition duration-200 hover:-translate-y-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

        <!-- Main Content Area -->
        <main class="flex-grow p-6 overflow-y-auto pb-40">
            <div class="max-w-7xl mx-auto space-y-6">

                <!-- Header Section -->
                <div class="card-3d p-6 rounded-2xl flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-black text-white drop-shadow">
                            Order & Commission Management
                        </h1>
                        <p class="text-xs text-blue-200 mt-1">
                            Monitor transactions, admin fees, and payouts.
                        </p>
                    </div>
                    <div>
                        <form method="GET" action="{{ route('admin.orders.index') }}" id="adminStatusFilterForm">
                            <select name="status" onchange="document.getElementById('adminStatusFilterForm').submit()"
                                class="btn-3d px-4 py-2 rounded-xl bg-blue-900 text-yellow-300 border border-blue-500 text-xs font-black focus:ring-0 focus:border-blue-400 cursor-pointer outline-none">
                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}
                                    class="bg-blue-900 text-white">
                                    Total Orders ({{ $allCount }})
                                </option>
                                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}
                                    class="bg-blue-900 text-white">
                                    Pending ({{ $pendingCount }})
                                </option>
                                <option value="paid" {{ $status === 'paid' ? 'selected' : '' }}
                                    class="bg-blue-900 text-white">
                                    Paid ({{ $paidCount }})
                                </option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Flash Alert -->
                @if(session('success'))
                    <div
                        class="card-3d p-4 rounded-2xl bg-emerald-900/60 border border-emerald-500 text-emerald-200 flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-400 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-bold text-sm">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Summary Cards Section -->
                <!-- Summary Cards Section (အမြဲတမ်း ပုံသေ ငွေပမာဏပြမည်) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Sales Card -->
                    <div
                        class="card-3d p-6 rounded-2xl flex justify-between items-center transform transition duration-200 hover:-translate-y-1">
                        <div>
                            <span class="text-xs font-black text-blue-200 uppercase tracking-wider">Total Sales Amount
                                (Paid)</span>
                            <div class="text-3xl font-black mt-2 text-white drop-shadow-md">
                                {{ number_format($totalRevenue) }} <span
                                    class="text-xs font-normal text-blue-200">MMK</span>
                            </div>
                        </div>
                        <!-- <div class="text-2xl bg-blue-900/80 p-3 rounded-xl border border-blue-500">💳</div> -->
                    </div>

                    <!-- Admin Commission Card -->
                    <div
                        class="card-3d p-6 rounded-2xl flex justify-between items-center transform transition duration-200 hover:-translate-y-1">
                        <div>
                            <span class="text-xs font-black text-blue-200 uppercase tracking-wider">Admin Commission
                                (2%)</span>
                            <div class="text-3xl font-black mt-2 text-emerald-300 drop-shadow-md">
                                +{{ number_format($totalCommission) }} <span
                                    class="text-xs font-normal text-blue-200">MMK</span>
                            </div>
                        </div>
                        <!-- <div class="text-2xl bg-blue-900/80 p-3 rounded-xl border border-blue-500">🏦</div> -->
                    </div>

                    <!-- Vendor Amount Card -->
                    <div
                        class="card-3d p-6 rounded-2xl flex justify-between items-center transform transition duration-200 hover:-translate-y-1">
                        <div>
                            <span class="text-xs font-black text-blue-200 uppercase tracking-wider">Vendor Payout
                                (98%)</span>
                            <div class="text-3xl font-black mt-2 text-cyan-300 drop-shadow-md">
                                {{ number_format($totalVendorPayout) }} <span
                                    class="text-xs font-normal text-blue-200">MMK</span>
                            </div>
                        </div>
                        <!-- <div class="text-2xl bg-blue-900/80 p-3 rounded-xl border border-blue-500">🏪</div> -->
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Sales Card -->
                    <div
                        class="card-3d p-6 rounded-2xl flex justify-between items-center transform transition duration-200 hover:-translate-y-1">
                        <div>
                            <span class="text-xs font-black text-blue-200 uppercase tracking-wider">Total Sales
                                Amount (Paid)</span>
                            <div class="text-3xl font-black mt-2 text-white drop-shadow-md">
                                {{ number_format($totalRevenue) }} <span
                                    class="text-xs font-normal text-blue-200">MMK</span>
                            </div>
                        </div>
                        <!-- <div class="text-2xl bg-blue-900/80 p-3 rounded-xl border border-blue-500">💳</div> -->
                    </div>

                    <!-- Admin Commission Card -->
                    <div
                        class="card-3d p-6 rounded-2xl flex justify-between items-center transform transition duration-200 hover:-translate-y-1">
                        <div>
                            <span class="text-xs font-black text-blue-200 uppercase tracking-wider">Admin Commission
                                (2%)</span>
                            <div class="text-3xl font-black mt-2 text-emerald-300 drop-shadow-md">
                                +{{ number_format($totalCommission) }} <span
                                    class="text-xs font-normal text-blue-200">MMK</span>
                            </div>
                        </div>
                        <div class="text-2xl bg-blue-900/80 p-3 rounded-xl border border-blue-500">🏦</div>
                    </div>

                    <!-- Vendor Amount Card -->
                    <div
                        class="card-3d p-6 rounded-2xl flex justify-between items-center transform transition duration-200 hover:-translate-y-1">
                        <div>
                            <span class="text-xs font-black text-blue-200 uppercase tracking-wider">Vendor Payout
                                (98%)</span>
                            <div class="text-3xl font-black mt-2 text-cyan-300 drop-shadow-md">
                                {{ number_format($totalVendorPayout) }} <span
                                    class="text-xs font-normal text-blue-200">MMK</span>
                            </div>
                        </div>
                        <div class="text-2xl bg-blue-900/80 p-3 rounded-xl border border-blue-500">🏪</div>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="space-y-6">
                    @forelse($orders as $order)
                        <div class="card-3d rounded-2xl overflow-hidden">

                            <!-- Order Card Header -->
                            <div
                                class="p-5 bg-blue-950/60 border-b border-blue-800 flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-blue-800 border border-blue-500 flex items-center justify-center font-black text-yellow-400 text-lg shadow">
                                        #{{ $order->id }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-white text-base flex items-center gap-2">
                                            {{ $order->customer_name }}
                                            <span
                                                class="text-xs font-normal text-blue-200">({{ $order->customer_phone }})</span>
                                        </div>
                                        <div class="text-xs text-blue-300 mt-0.5">
                                            📍 {{ $order->shipping_address }} • <span
                                                class="text-blue-200">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <!-- Status Badge -->
                                    @if($order->status === 'paid')
                                        <span
                                            class="btn-3d text-[11px] font-black text-emerald-300 bg-emerald-900/80 border border-emerald-500 px-3 py-1.5 rounded-xl">
                                            ● Paid
                                        </span>
                                    @else
                                        <span
                                            class="btn-3d text-[11px] font-black text-amber-300 bg-amber-900/80 border border-amber-500 px-3 py-1.5 rounded-xl">
                                            ● {{ ucfirst($order->status) }}
                                        </span>
                                    @endif

                                    <!-- Total Amount -->
                                    <div class="text-right">
                                        <div class="text-xs text-blue-200">Total Amount</div>
                                        <div class="text-lg font-black text-cyan-300">
                                            {{ number_format($order->total_amount) }} MMK
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items Table -->
                            <div class="p-5 overflow-x-auto">
                                <table class="w-full text-left text-sm text-blue-100">
                                    <thead>
                                        <tr
                                            class="border-b border-blue-800/80 text-xs uppercase text-blue-300 font-bold tracking-wider">
                                            <th class="pb-3 px-3">Product</th>
                                            <th class="pb-3 px-3">Vendor</th>
                                            <th class="pb-3 px-3 text-center">Qty</th>
                                            <th class="pb-3 px-3 text-right">Unit Price</th>
                                            <th class="pb-3 px-3 text-right">Subtotal</th>
                                            <th class="pb-3 px-3 text-right text-emerald-300">Admin Fee</th>
                                            <th class="pb-3 px-3 text-right text-cyan-300">Vendor Share</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-blue-800/50">
                                        @foreach($order->items as $item)
                                            @php
                                                $itemTotal = $item->price * $item->quantity;
                                                $adminComm = $item->admin_commission > 0 ? $item->admin_commission : ($itemTotal * 0.02);
                                                $vendorAmt = $item->vendor_amount > 0 ? $item->vendor_amount : ($itemTotal - $adminComm);
                                            @endphp
                                            <tr class="hover:bg-blue-800/30 transition-colors">
                                                <td class="py-3 px-3 font-semibold text-white">
                                                    {{ $item->product->name ?? 'Product Deleted' }}
                                                    @if($item->color || $item->size)
                                                        <span class="text-xs text-blue-300 font-normal block">
                                                            ({{ implode(', ', array_filter([$item->color, $item->size])) }})
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-3">
                                                    <span
                                                        class="btn-3d px-2.5 py-1 rounded-lg bg-blue-900 text-xs text-yellow-300 border border-blue-700 font-bold inline-block">
                                                        {{ $item->vendor->shop_name ?? $item->vendor->name ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-3 text-center font-bold text-white">{{ $item->quantity }}
                                                </td>
                                                <td class="py-3 px-3 text-right">{{ number_format($item->price) }} MMK</td>
                                                <td class="py-3 px-3 text-right font-bold text-white">
                                                    {{ number_format($itemTotal) }} MMK
                                                </td>
                                                <td class="py-3 px-3 text-right font-bold text-emerald-300">
                                                    +{{ number_format($adminComm) }} MMK
                                                </td>
                                                <td class="py-3 px-3 text-right font-bold text-cyan-300">
                                                    {{ number_format($vendorAmt) }} MMK
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    @empty
                        <div class="card-3d p-12 text-center rounded-2xl">
                            <div class="text-4xl mb-3">📦</div>
                            <h3 class="text-lg font-bold text-white">There are no orders yet.</h3>
                        </div>
                    @endforelse
                </div>

            </div>
        </main>

        <script>
            const menuBtn = document.getElementById('menuBtn');
            const closeBtn = document.getElementById('closeBtn');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const darkModeRow = document.getElementById('darkModeRow');

            function updateTheme(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    if (darkModeText) darkModeText.textContent = 'Day Mode';
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    if (darkModeText) darkModeText.textContent = 'Night Mode';
                }
            }

            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                updateTheme(true);
            } else {
                updateTheme(false);
            }

            if (darkModeRow) {
                darkModeRow.addEventListener('click', () => {
                    const isDark = document.documentElement.classList.contains('dark');
                    updateTheme(!isDark);
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
    </body>

    </html>
</x-app-layout>