@props(['campaign' => new \App\Models\Campaign()])

<div>
    <label class="block text-sm mb-4">
        <x-admin::label value="Nama" required />
        <x-admin::input type="text" name="name" placeholder="Nama" :error="$errors->has('name')" :value="old('name', $campaign->name)" />
        @error('name')
            <x-admin::input-helper error :value="$message" />
        @enderror
    </label>
    <label class="block text-sm mb-4">
        <x-admin::label value="Slug" />
        <x-admin::input type="text" name="slug" placeholder="Slug" :error="$errors->has('slug')" :value="old('slug', $campaign->slug)" />
        <x-admin::input-helper value="Biarkan kosong untuk generate otomatis" />
        @error('slug')
            <x-admin::input-helper error :value="$message" />
        @enderror
    </label>
    <label class="block text-sm mb-4" x-data="CoverComponent()" x-init="init()">
        <x-admin::label value="Cover" required />
        <img x-bind:src="previewUrl" x-show="previewUrl" class="h-40" />
        <x-admin::input type="file" name="cover" accept="image/*" x-on:change="handleChange($event)" :error="$errors->has('cover')" />
        @error('cover')
            <x-admin::input-helper error :value="$message" />
        @enderror
    </label>
    <script>
        function CoverComponent() {
            return {
                previousUrl: '{{ $campaign->thumbnail_cover_url }}' ?? null,
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
        <x-admin::label value="Deskripsi" />
        <x-admin::rich-editor id="description" name="description" placeholder="Deskripsi" :value="old('description', $campaign->description)" />
    </label>
    <label class="block text-sm mb-4">
        <x-admin::label value="Kebutuhan Dana" />
        <x-admin::input type="number" name="funds" :value="old('funds', $campaign->funds)" />
        <x-admin::input-helper value="Biarkan kosong untuk tidak ada batasan" />
    </label>
    <label class="block text-sm mb-4">
        <x-admin::label value="Waktu Ditutup" />
        <x-admin::input type="date" name="closed_at" :value="old('closed_at', $campaign->closed_at ? $campaign->closed_at->format('Y-m-d') : null)" />
        <x-admin::input-helper value="Biarkan kosong untuk tidak ada batasan" />
    </label>
    <label class="block text-sm mb-4">
        <x-admin::label value="Terbitkan" />
        <x-admin::checkbox label="Ya" name="publish" value="1" :checked="old('publish') == 1 || !empty($campaign->published_at)" />
    </label>
    <label class="block text-m mb-4">
        <x-admin::label value="Kode Unik Transaksi Paling Belakang (Maksimal: 3 angka)" />
        <x-admin::input type="number" name="unique_code_sufix" max="999" :value="old('unique_code_sufix', $campaign->unique_code_sufix)" />
        <x-admin::input-helper value="Biarkan kosong untuk diacak" />
    </label>
</div>
