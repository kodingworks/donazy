<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::banners.index')" />
        <x-admin::page-title value="Ubah Banner" />
    </div>

    <x-admin::form-container>
        <form action="{{ route('admin::banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label class="block text-sm mb-4" x-data="ImageInput()" x-init="init()">
                <x-admin::label value="Gambar" required />
                <img src="{{ $banner->thumbnail_url }}" class="h-40" />
            </label>
            <label class="block text-sm mb-4">
                <x-admin::label value="Urutan" />
                <x-admin::input type="number" name="sort" min="1" :value="$banner->sort" />
                <x-admin::input-helper value="Biarkan kosong untuk urutan pertama" />
            </label>
            <x-admin::button variant="primary" type="submit" value="Simpan" />
        </form>
    </x-admin::form-container>
</x-admin::app>
