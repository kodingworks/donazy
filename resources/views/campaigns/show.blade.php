<x-app>
    <header class="fixed top-0 inset-x-0 z-10">
        <x-bg-main>
            <x-container>
                <div class="flex items-center space-x-2 p-2">
                    <x-button-back />
                    <h3 class="line-clamp-1">{{ $campaign->name }}</h3>
                </div>
            </x-container>
        </x-bg-main>
    </header>

    <x-container>
        <main class="py-20">
            <div id="card-campaign">
                <img src="{{ $campaign->original_cover_url }}" class="w-full" />
                <x-bg-main class="p-4">
                    <h2 class="text-lg font-semibold">{{ $campaign->name }}</h2>
                    <p class="mt-4">
                        <span class="text-primary font-semibold">@idr($campaign->collected_funds)</span>
                        @if ($campaign->funds)
                            <span class="text-sm font-light">terkumpul dari @idr($campaign->funds)</span>
                        @endif
                    </p>
                    <div class="h-2 bg-gray-200 rounded my-2 overflow-hidden">
                        <div style="width: {{ $campaign->collected_funds_percentage }}" class="h-2 bg-primary"></div>
                    </div>
                    <div class="flex justify-between items-center">
                        <p>
                            <span class="font-semibold">{{ $campaign->donors }}</span>
                            <span class="text-sm font-light">Donatur</span>
                        </p>
                        @if ($campaign->canClose() && !$campaign->isClosed())
                            <p>
                                @if ($campaign->time_left > 0)
                                    <span class="font-semibold">{{ $campaign->time_left }}</span>
                                    <span class="text-sm font-light">Hari lagi</span>
                                @else
                                    <span class="font-semibold">Hari terakhir</span>
                                @endif
                            </p>
                        @endif
                    </div>
                    <a
                        href="{{ !$campaign->isClosed() ? route('campaigns.transactions.create', ['slug' => $campaign->slug]) : '#' }}"
                        class="block py-2 px-3 rounded bg-primary text-white text-center font-semibold mt-4 {{ $campaign->isClosed() ? 'opacity-50' : null }}"
                    >Donasi sekarang</a>
                </x-bg-main>
            </div>

            <div class="mb-2"></div>

            <x-bg-main class="p-4">
                <div class="flex justify-between items-start">
                    <h3 class="text-lg font-semibold">Deskripsi</h3>
                    <p class="text-gray-500">{{ $campaign->created_at->format('d F Y') }}</p>
                </div>
                <div class="mt-6">
                    {!! $campaign->description !!}
                </div>
            </x-bg-main>

            <div class="mb-2"></div>

            <x-bg-main class="p-4">
                <h3 class="text-lg font-semibold">Donatur ({{ $campaign->donors }})</h3>

                <div class="mt-4">
                    @foreach ($transactions as $transaction)
                        <div class="flex items-center space-x-2 shadow bg-gray-100 rounded p-2 mb-2">
                            <img src="https://via.placeholder.com/50" class="h-16 rounded-full" />
                            <div>
                                <p class="text-primary leading-tight">{{ !$transaction->isAnonymous() ? $transaction->user_name : 'Hamba Allah' }}</p>
                                <p class="leading-tight">
                                    <span>Donasi</span>
                                    <span class="font-semibold">@idr($transaction->total)</span>
                                </p>
                                <p class="text-sm">{{ $transaction->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-bg-main>
        </main>
    </x-container>

    <div id="bottom-bar" class="fixed bottom-0 inset-x-0 z-10 border-t hidden">
        <x-bg-main>
            <x-container>
                <div class="px-4 py-3">
                    <a
                        href="{{ !$campaign->isClosed() ? route('campaigns.transactions.create', ['slug' => $campaign->slug]) : '#' }}"
                        class="block py-2 px-3 rounded bg-primary text-white text-center font-semibold mt-4 {{ $campaign->isClosed() ? 'opacity-50' : null }}"
                    >Donasi sekarang</a>
                </div>
            </x-container>
        </x-bg-main>
    </div>
    <script>
        const cardCampaign = document.getElementById('card-campaign');
        const bottomBar = document.getElementById('bottom-bar');

        window.onscroll = function (event) {
            if (window.pageYOffset >= cardCampaign.offsetHeight) {
                bottomBar.classList.remove('hidden');
            } else {
                bottomBar.classList.add('hidden');
            }
        }
    </script>
</x-app>
