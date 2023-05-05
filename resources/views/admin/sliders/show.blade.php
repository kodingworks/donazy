<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::sliders.index')" />
        <x-admin::page-title value="Detail Pengguna" />
    </div>

    <x-admin::card>
        <div class="mb-4">
            <x-admin::label value="Nama" />
            <p class="text-sm">{{ $slider->name }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Waktu Dibuat" />
            <p class="text-sm">{{ $slider->created_at }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Program" />
            <ul>
                @foreach ($campaigns as $campaign)
                    <li class="px-4 py-2 flex items-center space-x-4 border border-gray-200">
                        <img
                            src="{{ $campaign->thumbnail_cover_url }}"
                            class="w-24 h-12 object-cover"
                        />
                        <span>{{ $campaign->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="flex items-center space-x-2">
            <x-admin::link variant="primary" :href="route('admin::sliders.edit', $slider)" value="Ubah" />
            <x-admin::button-delete :action="route('admin::sliders.destroy', $slider)" />
        </div>
    </x-admin::card>
</x-admin::app>
