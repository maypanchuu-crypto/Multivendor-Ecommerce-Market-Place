<x-app-layout>
    <div class="min-h-screen bg-slate-900 text-slate-100 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- Header Section --}}
            <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 rounded-3xl bg-gradient-to-r from-blue-900/60 via-indigo-900/40 to-slate-900 border border-blue-500/30 shadow-[0_10px_30px_rgba(30,58,138,0.5)] backdrop-blur-xl">
                <div>
                    <h1
                        class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-200 tracking-wide">
                        Order & Commission Management
                    </h1>
                    <p class="text-slate-400 text-sm mt-1">အော်ဒါအသေးစိတ်၊ Admin ကော်မရှင်နှင့် Vendor Share များအား
                        စစ်ဆေးသည့်နေရာ</p>
                </div>
                <div class="flex items-center gap-3">
                    <span
                        class="px-4 py-2 rounded-2xl bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs font-bold shadow-[inset_0_2px_4px_rgba(255,255,255,0.1)]">
                        Total Orders: {{ $orders->count() }}
                    </span>
                </div>
            </div>

            {{-- Flash Alert --}}
            @if(session('success'))
                <div
                    class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/40 text-emerald-300 shadow-[0_4px_20px_rgba(16,185,129,0.2)] flex items-center gap-3">
                    <svg class="w-6 h-6 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Summary Cards (3D Blue Style) --}}
            @php
                $totalRevenue = $orders->sum('total_amount');
                $totalCommission = $orders->flatMap->items->sum('admin_commission');
                $totalVendorPayout = $orders->flatMap->items->sum('vendor_amount');
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Sales Card -->
                <div
                    class="relative group p-6 rounded-3xl bg-gradient-to-b from-blue-600/30 to-blue-900/40 border border-blue-400/30 shadow-[0_15px_35px_rgba(37,99,235,0.25)] hover:shadow-[0_20px_40px_rgba(37,99,235,0.4)] transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-xs font-bold uppercase tracking-wider text-blue-300 mb-2">Total Sales Amount</div>
                    <div class="text-3xl font-extrabold text-white">{{ number_format($totalRevenue) }} <span
                            class="text-sm font-normal text-blue-300">MMK</span></div>
                    <div
                        class="absolute top-4 right-4 p-3 bg-blue-500/20 rounded-2xl border border-blue-300/20 text-blue-300">
                        💳
                    </div>
                </div>

                <!-- Admin Commission Card -->
                <div
                    class="relative group p-6 rounded-3xl bg-gradient-to-b from-indigo-600/30 to-indigo-900/40 border border-indigo-400/30 shadow-[0_15px_35px_rgba(79,70,229,0.25)] hover:shadow-[0_20px_40px_rgba(79,70,229,0.4)] transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-xs font-bold uppercase tracking-wider text-indigo-300 mb-2">Admin Commission (2%)
                    </div>
                    <div class="text-3xl font-extrabold text-emerald-400">+{{ number_format($totalCommission) }} <span
                            class="text-sm font-normal text-indigo-300">MMK</span></div>
                    <div
                        class="absolute top-4 right-4 p-3 bg-indigo-500/20 rounded-2xl border border-indigo-300/20 text-indigo-300">
                        🏦
                    </div>
                </div>

                <!-- Vendor Amount Card -->
                <div
                    class="relative group p-6 rounded-3xl bg-gradient-to-b from-sky-600/30 to-sky-900/40 border border-sky-400/30 shadow-[0_15px_35px_rgba(14,165,233,0.25)] hover:shadow-[0_20px_40px_rgba(14,165,233,0.4)] transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-xs font-bold uppercase tracking-wider text-sky-300 mb-2">Vendor Payout (98%)</div>
                    <div class="text-3xl font-extrabold text-cyan-300">{{ number_format($totalVendorPayout) }} <span
                            class="text-sm font-normal text-sky-300">MMK</span></div>
                    <div
                        class="absolute top-4 right-4 p-3 bg-sky-500/20 rounded-2xl border border-sky-300/20 text-sky-300">
                        🏪
                    </div>
                </div>
            </div>

            {{-- Orders List --}}
            <div class="space-y-6">
                @forelse($orders as $order)
                    <div
                        class="rounded-3xl bg-slate-800/80 border border-blue-500/20 shadow-[0_10px_30px_rgba(0,0,0,0.5)] overflow-hidden transition-all hover:border-blue-500/40">

                        {{-- Order Header --}}
                        <div
                            class="p-5 bg-gradient-to-r from-blue-950/80 via-slate-900 to-slate-900/90 border-b border-blue-500/20 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-blue-600/20 border border-blue-400/40 flex items-center justify-center font-black text-blue-400 text-lg shadow-[inset_0_2px_4px_rgba(255,255,255,0.1)]">
                                    #{{ $order->id }}
                                </div>
                                <div>
                                    <div class="font-bold text-white text-base flex items-center gap-2">
                                        {{ $order->customer_name }}
                                        <span
                                            class="text-xs font-normal text-slate-400">({{ $order->customer_phone }})</span>
                                    </div>
                                    <div class="text-xs text-slate-400 mt-0.5">
                                        📍 {{ $order->shipping_address }} • <span
                                            class="text-slate-500">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                {{-- Status Badge --}}
                                @if($order->status === 'paid' || $order->status === 'completed')
                                    <span
                                        class="px-3.5 py-1.5 rounded-xl bg-emerald-500/10 border border-emerald-500/40 text-emerald-400 text-xs font-bold shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                                        ● Paid / Completed
                                    </span>
                                @else
                                    <span
                                        class="px-3.5 py-1.5 rounded-xl bg-amber-500/10 border border-amber-500/40 text-amber-400 text-xs font-bold shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                                        ● {{ ucfirst($order->status) }}
                                    </span>
                                @endif

                                {{-- Total Amount --}}
                                <div class="text-right">
                                    <div class="text-xs text-slate-400">Total Amount</div>
                                    <div class="text-lg font-black text-blue-400">{{ number_format($order->total_amount) }}
                                        MMK</div>
                                </div>

                                {{-- Approve Button --}}
                                @if($order->status !== 'paid' && $order->status !== 'completed')
                                    <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-xs font-bold shadow-[0_4px_15px_rgba(37,99,235,0.4)] active:scale-95 transition-all">
                                            Approve & Split
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        {{-- Order Items Table --}}
                        <div class="p-5 overflow-x-auto">
                            <table class="w-full text-left text-sm text-slate-300">
                                <thead>
                                    <tr
                                        class="border-b border-slate-700/60 text-xs uppercase text-slate-400 font-semibold tracking-wider">
                                        <th class="pb-3 px-3">Product</th>
                                        <th class="pb-3 px-3">Vendor</th>
                                        <th class="pb-3 px-3 text-center">Qty</th>
                                        <th class="pb-3 px-3 text-right">Unit Price</th>
                                        <th class="pb-3 px-3 text-right">Subtotal</th>
                                        <th class="pb-3 px-3 text-right text-emerald-400">Admin Fee</th>
                                        <th class="pb-3 px-3 text-right text-cyan-400">Vendor Share</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-700/40">
                                    @foreach($order->items as $item)
                                        @php
                                            $itemTotal = $item->price * $item->quantity;
                                            // DB ထဲမှာ admin_commission ရှိရင် ယူမည်၊ မရှိသေးရင် 2% ခန့်မှန်းတွက်ပြမည်
                                            $adminComm = $item->admin_commission > 0 ? $item->admin_commission : ($itemTotal * 0.02);
                                            $vendorAmt = $item->vendor_amount > 0 ? $item->vendor_amount : ($itemTotal - $adminComm);
                                        @endphp
                                        <tr class="hover:bg-slate-700/20 transition-colors">
                                            <td class="py-3 px-3 font-semibold text-white">
                                                {{ $item->product->name ?? 'Product Deleted' }}
                                                @if($item->color || $item->size)
                                                    <span class="text-xs text-slate-400 font-normal block">
                                                        ({{ implode(', ', array_filter([$item->color, $item->size])) }})
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-3 text-slate-300">
                                                <span
                                                    class="px-2.5 py-1 rounded-lg bg-slate-700/60 text-xs text-blue-300 border border-slate-600">
                                                    {{ $item->vendor->shop_name ?? $item->vendor->name ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-3 text-center font-bold text-white">{{ $item->quantity }}</td>
                                            <td class="py-3 px-3 text-right">{{ number_format($item->price) }} MMK</td>
                                            <td class="py-3 px-3 text-right font-bold text-slate-200">
                                                {{ number_format($itemTotal) }} MMK</td>
                                            <td class="py-3 px-3 text-right font-semibold text-emerald-400">
                                                +{{ number_format($adminComm) }} MMK</td>
                                            <td class="py-3 px-3 text-right font-semibold text-cyan-300">
                                                {{ number_format($vendorAmt) }} MMK</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                @empty
                    <div class="p-12 text-center rounded-3xl bg-slate-800/50 border border-blue-500/20 shadow-xl">
                        <div class="text-4xl mb-3">📦</div>
                        <h3 class="text-lg font-bold text-slate-300">မည့်သည့် Order မှ မရှိသေးပါ။</h3>
                        <p class="text-slate-500 text-sm mt-1">Customer များမှ Order တင်လာပါက ဤနေရာတွင် ပေါ်လာပါမည်။</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>