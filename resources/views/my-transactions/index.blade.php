<x-app>
    <header class="fixed top-0 inset-x-0 z-10">
        <x-bg-main>
            <x-container>
                <div class="flex items-center space-x-2 p-2">
                    <x-button-back href="/" />
                    <h3 class="line-clamp-1">Donasi Saya</h3>
                </div>
            </x-container>
        </x-bg-main>
    </header>

    <x-container>
        <main class="py-20">
            <x-bg-main class="p-4">
                <div>Total Donasi</div>
                <div class="text-2xl text-primary text-right font-semibold">@idr($paidTransactionTotal)</div>
            </x-bg-main>

            <div class="mb-4"></div>

            <x-bg-main class="p-4">
                @if ($transactions->isNotEmpty())
                    @foreach ($transactions as $transaction)
                        <a href="{{ route('transactions.show', ['code' => $transaction->code]) }}" class="flex items-start space-x-4">
                            <div class="rounded overflow-hidden">
                                <img src="{{ $transaction->campaign->thumbnail_cover_url }}" alt="{{ $transaction->campaign->name }}" class="w-20 h-20 object-cover object-center" />
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start space-x-4">
                                    <h3 class="font-semibold mb-4">{{ $transaction->campaign->name }}</h3>
                                    @switch($transaction->status)
                                        @case(\App\Models\Transaction::STATUS_WAITING)
                                            <div class="w-24 px-2 py-1 rounded-full border border-gray-600 text-gray-600 text-center text-xs">{{ $transaction->status }}</div>
                                            @break
                                        @case(\App\Models\Transaction::STATUS_PAID)
                                            <div class="w-24 px-2 py-1 rounded-full border border-primary text-primary text-center text-xs">{{ $transaction->status }}</div>
                                            @break
                                        @case(\App\Models\Transaction::STATUS_EXPIRED)
                                        @case(\App\Models\Transaction::STATUS_CANCELED)
                                            <div class="w-24 px-2 py-1 rounded-full border border-red-600 text-red-600 text-center text-xs">{{ $transaction->status }}</div>
                                            @break
                                    @endswitch
                                </div>
                                <div class="text-xs">
                                    <span>{{ $transaction->created_at }}</span>
                                    <span class="font-semibold">@idr($transaction->total)</span>
                                </div>
                            </div>
                        </a>

                        <div class="my-4 @if(!$loop->last) border @endif"></div>
                    @endforeach

                    <x-pagination :collection="$transactions" />
                @else
                    <div class="p-4 flex flex-col justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>Data masih kosong</div>
                    </div>
                @endif
            </x-bg-main>

        </main>
    </x-container>

    <x-bottom-bar />
</x-app>
