<x-admin::app>
    <x-admin::success-alert />

    <div class="flex justify-between items-center space-x-2 rounded-lg mb-4">
        <div>
            <x-admin::page-title value="Banner" />
        </div>
        <div>
            <x-admin::link variant="primary" :href="route('admin::banners.create')" value="Tambah" class="mt-1" />
        </div>
    </div>

    @if ($banners->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($banners as $banner)
                <div class="rounded-lg shadow-md overflow-hidden">
                    <img src="{{ $banner->thumbnail_url }}" alt="{{ $banner->id }}" class="w-full" />
                    <div class="flex justify-center items-center text-sm px-3 py-2">
                        <x-admin::row-show-action :href="route('admin::banners.show', $banner)" />
                        <x-admin::row-edit-action :href="route('admin::banners.edit', $banner)" />
                        <x-admin::row-delete-action :href="route('admin::banners.destroy', $banner)" />
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="w-full rounded-lg shadow-md p-4">
            <x-admin::empty />
        </div>
    @endif

    <x-admin::pagination :collection="$banners" />
</x-admin::app>
