<x-app-layout :hideNav="true">
    <div class="min-h-screen bg-slate-100 flex items-center justify-center p-4">
        <div class="bg-white max-w-sm w-full rounded-3xl p-8 shadow-xl text-center">
            <div
                class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-black text-slate-800">🎉 Successful!</h2>
            <p class="text-xs text-slate-500 mt-1">Order #{{ $order->id }} အတွက် ငွေပေးချေမှု အောင်မြင်ပါသည်။</p>

            <a href="/" class="mt-6 inline-block w-full bg-slate-800 text-white text-xs font-bold py-3 rounded-2xl">
                Home သို့ ပြန်သွားမည်
            </a>
        </div>
    </div>
</x-app-layout>