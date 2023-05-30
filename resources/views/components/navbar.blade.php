<div>
    <div x-data="{ open: false }" class="flex flex-col py-4 md:items-center md:justify-between md:flex-row">
        <div class="flex flex-row items-center justify-between">
            <a href="#" class="block">
                <img src="https://i.ibb.co/F7K52H7/donazy-logo-rounded.png" alt="{{ Config::get('app.name') }}" class="h-10">
            </a>
            <button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" x-on:click="open = !open">
                <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                    <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <nav :class="{'flex': open, 'hidden': !open}" class="flex-col flex-grow mt-4 md:mt-0 hidden md:flex md:justify-end md:flex-row md:space-x-4">
            <a class="px-4 py-2 mt-2 md:mt-0 text-sm font-semibold text-white bg-primary rounded-lg focus:outline-none focus:shadow-outline" href="#">{{ __('Home') }}</a>
            <a class="px-4 py-2 mt-2 md:mt-0 text-sm font-semibold bg-transparent rounded-lg hover:text-white focus:text-white hover:bg-primary focus:bg-primary focus:outline-none focus:shadow-outline" href="#">{{ __('Campaigns') }}</a>
        </nav>
    </div>
</div>
