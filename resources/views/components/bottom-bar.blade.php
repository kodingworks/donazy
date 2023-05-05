<nav class="fixed bottom-0 inset-x-0 z-10 border-t">
    <x-bg-main>
        <x-container>
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-primary' : 'text-gray-400' }} active:text-primary hover:text-primary text-center flex flex-col flex-1 items-center px-2 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    <span class="whitespace-nowrap text-xs mt-1">Beranda</span>
                </a>
                <a href="{{ route('campaigns.index') }}" class="{{ request()->routeIs('campaigns.index') ? 'text-primary' : 'text-gray-400' }} active:text-primary hover:text-primary text-center flex flex-col flex-1 items-center px-2 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                    </svg>
                    <span class="whitespace-nowrap text-xs mt-1">Program</span>
                </a>
                <a href="{{ route('my-transactions.index') }}" class="{{ request()->routeIs('my-transactions.index') ? 'text-primary' : 'text-gray-400' }} active:text-primary hover:text-primary text-center flex flex-col flex-1 items-center px-2 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span class="whitespace-nowrap text-xs mt-1">Donasi Saya</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'text-primary' : 'text-gray-400' }} active:text-primary hover:text-primary text-center flex flex-col flex-1 items-center px-2 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="whitespace-nowrap text-xs mt-1">Akun</span>
                </a>
            </div>
        </x-container>
    </x-bg-main>
</nav>
