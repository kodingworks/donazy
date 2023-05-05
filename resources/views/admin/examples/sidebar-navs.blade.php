<div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
        {{ config('app.name', 'Laravel') }}
    </a>
    <ul class="mt-6">
        <x-admin::nav-link label="Menu 1" url="#" />
        <x-admin::nav-link label="Menu 2" url="#" />
        <x-admin::dropdown-nav label="Menu 3">
            <x-admin::dropdown-nav-link label="Sub Menu 1" url="#" />
            <x-admin::dropdown-nav-link label="Sub Menu 2" url="#" />
            <x-admin::dropdown-nav-link label="Sub Menu 3" url="#" />
        </x-admin::dropdown-nav>
    </ul>
    <div class="px-6 my-6">
        <button
            class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary border border-transparent rounded-lg active:bg-primary hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Create account
            <span class="ml-2" aria-hidden="true">+</span>
        </button>
    </div>
</div>
