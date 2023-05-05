<x-app>
    <header class="fixed top-0 inset-x-0 z-10">
        <x-bg-main>
            <x-container>
                <form action="{{ route('campaigns.index') }}" method="GET">
                    <div class="flex items-center space-x-2 p-2">
                        <x-button-back />
                        <label class="block w-full relative text-gray-300 focus-within:text-primary">
                            <input
                                type="search"
                                name="search"
                                placeholder="Cari program"
                                value="{{ request('search') }}"
                                class="w-full rounded-full pl-4 pr-8 bg-gray-50 border-gray-300 focus:border-primary focus:ring-primary"
                            />
                            <svg class="absolute right-0 top-0 h-5 w-5 mt-3 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </label>
                    </div>
                </form>
            </x-container>
        </x-bg-main>
    </header>

    <x-container>
        <main class="py-20">
            <x-bg-main class="p-4">
                @if ($campaigns->isNotEmpty())
                    @foreach ($campaigns as $campaign)
                        <x-card-campaign :campaign="$campaign" />
                        <div class="my-4 @if(!$loop->last) border @endif"></div>
                    @endforeach

                    <x-pagination :collection="$campaigns" />
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
