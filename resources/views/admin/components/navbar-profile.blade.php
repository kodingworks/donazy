<li class="relative" x-data="{ open: false }">
    <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none" x-on:click="open = !open"
        x-on:keydown.escape="open = false" aria-label="Account" aria-haspopup="true">
        <img class="object-cover w-8 h-8 rounded-full"
            src="https://via.placeholder.com/50"
            alt="" aria-hidden="true" />
    </button>
    <div x-show="open">
        <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-on:click.away="open = false" x-on:keydown.escape="open = false"
            class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
            aria-label="submenu">
            <li class="flex">
                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                    href="{{ route('admin::profile.edit') }}">
                    <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Profil Saya</span>
                </a>
            </li>
            <li class="flex">
                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                    href="#" x-data x-on:click="$refs.submit.click()">
                    <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span>Keluar</span>
                    <form action="{{ route('admin::auth.logout') }}" method="POST" class="hidden"
                        onsubmit="return confirm('{{ __('Apakah anda yakin untuk keluar?') }}')">
                        @csrf
                        <input type="submit" x-ref="submit">
                    </form>
                </a>
            </li>
        </ul>
    </div>
</li>
