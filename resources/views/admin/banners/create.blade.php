<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::banners.index')" />
        <x-admin::page-title value="Tambah Banner" />
    </div>

    <x-admin::form-container>
        <form action="{{ route('admin::banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="block text-sm mb-4" x-data="ImageInput()" x-init="init()">
                <x-admin::label value="Gambar" required />
                <img x-bind:src="previewUrl" x-show="previewUrl" class="h-40" />
                <x-admin::input type="file" name="image" accept="image/*" x-on:change="handleChange($event)" :error="$errors->has('image')" />
                @error('image')
                    <x-admin::input-helper error :value="$message" />
                @enderror
            </label>
            <script>
                function ImageInput() {
                    return {
                        previousUrl: null,
                        previewUrl: null,
                        handleChange(event) {
                            var file = event.target.files[0];

                            if (file) {
                                this.previewUrl = URL.createObjectURL(file);
                            } else {
                                this.previewUrl = this.previousUrl ?? null;
                            }

                        },
                        init() {
                            if (this.previousUrl) {
                                this.previewUrl = this.previousUrl;
                            }
                        }
                    };
                }
            </script>
            <label class="block text-sm mb-4">
                <x-admin::label value="Urutan" />
                <x-admin::input type="number" name="sort" min="1" />
                <x-admin::input-helper value="Biarkan kosong untuk urutan pertama" />
            </label>
            <x-admin::button variant="primary" type="submit" value="Simpan" />
        </form>
    </x-admin::form-container>
</x-admin::app>
