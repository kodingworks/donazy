<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::sliders.index')" />
        <x-admin::page-title value="Ubah Slider" />
    </div>

    <x-admin::form-container>
        <form action="{{ route('admin::sliders.update', $slider) }}" method="POST">
            @csrf
            @method('PUT')
            <x-admin::sliders.form :slider="$slider" :selectedCampaigns="$selectedCampaigns" />
            <x-admin::button variant="primary" type="submit" value="Simpan" />
        </form>
    </x-admin::form-container>
</x-admin::app>
