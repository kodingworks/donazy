<x-admin::label>
    <div class="relative text-gray-500 focus-within:text-primary dark:focus-within:text-primary">
        <x-admin::input type="search" name="search" :value="request('search')" class="pl-10" placeholder="Cari" />
        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</x-admin::label>
