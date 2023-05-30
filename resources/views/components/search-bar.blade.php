<header class="fixed top-0 inset-x-0 z-10">
    <x-bg-main>
        <x-container>
            <form action="{{ route('campaigns.index') }}" method="GET">
                <div class="flex items-center space-x-2 p-2">
                    <img onclick="location.href = 'https://github.com/kodingworks/donazy'" src="/images/donazy.png" alt="{{ Config::get('app.name') }}" class="h-12 cursor-pointer">
                    <label class="block w-full relative text-gray-300 focus-within:text-primary">
                        <input
                            type="search"
                            name="search"
                            placeholder="Cari program"
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
