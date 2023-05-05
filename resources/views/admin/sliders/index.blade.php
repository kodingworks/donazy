<x-admin::app>
    <x-admin::page-title value="Slider" />
    <x-admin::success-alert />

    <div class="flex justify-between items-center space-x-2 rounded-lg mb-4">
        <div>
            <form action="{{ route('admin::sliders.index') }}" method="GET">
                <x-admin::search />
            </form>
        </div>
        <div>
            <x-admin::link variant="primary" :href="route('admin::sliders.create')" value="Buat" class="mt-1" />
        </div>
    </div>

    <div class="w-full overflow-hidden rounded-lg shadow-md">
        <x-admin::table>
            <thead>
                <x-admin::col-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Urutan" name="sort" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Nama" name="name" />
                    </x-admin::row-header>
                    <x-admin::row-header>Aksi</x-admin::row-header>
                </x-admin::col-header>
            </thead>
            <x-admin::tbody>
                @forelse ($sliders as $slider)
                    <x-admin::col>
                        <x-admin::row>{{ $slider->sort }}</x-admin::row>
                        <x-admin::row>{{ $slider->name }}</x-admin::row>
                        <x-admin::row>
                            <div class="flex items-center text-sm">
                                <x-admin::row-show-action :href="route('admin::sliders.show', $slider)" />
                                <x-admin::row-edit-action :href="route('admin::sliders.edit', $slider)" />
                                <x-admin::row-delete-action :href="route('admin::sliders.destroy', $slider)" />
                            </div>
                        </x-admin::row>
                    </x-admin::col>
                @empty
                    <x-admin::col>
                        <x-admin::row colspan="6">
                            <x-admin::empty />
                        </x-admin::row>
                    </x-admin::col>
                @endforelse
            </x-admin::tbody>
        </x-admin::table>

        <x-admin::pagination :collection="$sliders" />
    </div>
</x-admin::app>
