<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::banners.index')" />
        <x-admin::page-title value="Detail Banner" />
    </div>

    <x-admin::card>
        <div class="mb-4">
            <x-admin::label value="Gambar" />
            <img src="{!! $banner->original_url !!}" class="w-full" />
        </div>
        <div class="mb-4">
            <x-admin::label value="Urutan" />
            <p class="text-sm">{!! $banner->sort !!}</p>
        </div>
        <div class="flex items-center space-x-2">
            <x-admin::link variant="primary" :href="route('admin::banners.edit', $banner)" value="Ubah" />
            <x-admin::button-delete :action="route('admin::banners.destroy', $banner)" />
        </div>
    </x-admin::card>
</x-admin::app>
