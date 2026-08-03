<x-app-layout :hideNav="true">

    @section('content')
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-8 px-4 sm:px-0">
                <h1 class="text-3xl font-black text-gray-800 dark:text-white flex items-center gap-3">
                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    My Order History
                </h1>
            </div>

            @if($orderItems->count() > 0)
                <!-- Orders Table / Cards Container -->
                <div
                    class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 text-xs uppercase font-extrabold tracking-wider border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-6 py-4">Product</th>
                                    <th class="px-6 py-4">Order ID</th>
                                    <th class="px-6 py-4">Price</th>
                                    <th class="px-6 py-4">Quantity</th>
                                    <th class="px-6 py-4">Subtotal</th>
                                    <th class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                                @foreach($orderItems as $item)
                                    <tr class="hover:bg-amber-50/50 dark:hover:bg-gray-700/35 transition-colors">
                                        <!-- Product Info with Image -->
                                        <td class="px-6 py-4 flex items-center gap-3">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-700 flex-shrink-0 overflow-hidden border border-gray-200 dark:border-gray-600">
                                                @if(isset($item->product->image))
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="font-bold text-gray-900 dark:text-white block">
                                                    {{ $item->product->name ?? $item->product_name ?? 'Product Name' }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $item->created_at->format('d M Y, h:i A') }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Order ID -->
                                        <td class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">
                                            #{{ $item->order->id ?? $item->order_id }}
                                        </td>

                                        <!-- Price -->
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                            {{ number_format($item->price) }} MMK
                                        </td>

                                        <!-- Quantity -->
                                        <td class="px-6 py-4 font-bold text-gray-800 dark:text-gray-200">
                                            x {{ $item->quantity }}
                                        </td>

                                        <!-- Subtotal -->
                                        <td class="px-6 py-4 font-black text-amber-600 dark:text-amber-400">
                                            {{ number_format($item->price * $item->quantity) }} MMK
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4">
                                            @if(optional($item->order)->status == 'pending')
                                                <span
                                                    class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">Pending</span>
                                            @elseif(optional($item->order)->status == 'completed')
                                                <span
                                                    class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Completed</span>
                                            @elseif(optional($item->order)->status == 'cancelled')
                                                <span
                                                    class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">Cancelled</span>
                                            @else
                                                <span
                                                    class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">{{ ucfirst(optional($item->order)->status ?? 'N/A') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                        {{ $orderItems->links() }}
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-12 text-center border border-gray-200 dark:border-gray-700">
                    <div
                        class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">You have not placed any orders yet!</h3>

                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-amber-400 to-yellow-500 text-gray-900 font-extrabold text-sm border-b-4 border-r-2 border-amber-700 shadow-[0_6px_0_0_rgba(0,0,0,0.2)] hover:translate-y-1 hover:shadow-[0_2px_0_0_rgba(0,0,0,0.2)] active:translate-y-1.5 active:shadow-none transition-all">
                        Shop Now
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>