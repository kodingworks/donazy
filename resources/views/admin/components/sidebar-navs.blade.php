<div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
        {{ config('app.name', 'Laravel') }}
    </a>
    <ul class="mt-6">
        <x-admin::nav-link label="Beranda" :url="route('admin::home')" :active="request()->routeIs('admin::home')" />
        <x-admin::nav-link label="Program" :url="route('admin::campaigns.index')" :active="request()->routeIs('admin::campaigns.*')" />
        <x-admin::nav-link label="Transaksi" :url="route('admin::transactions.index')" :active="request()->routeIs('admin::transactions.*')" />
        <x-admin::nav-link label="Mutasi" :url="route('admin::mutations.index')" />
        <x-admin::nav-link label="Metode Pembayaran" :url="route('admin::paymentMethod.index')" />
        <x-admin::nav-link label="Pengguna" :url="route('admin::users.index')" :active="request()->routeIs('admin::users.*')" />
        <x-admin::nav-link label="Banner" :url="route('admin::banners.index')" :active="request()->routeIs('admin::banners.*')" />
        <x-admin::nav-link label="Slider" :url="route('admin::sliders.index')" :active="request()->routeIs('admin::sliders.*')" />
    </ul>
</div>
