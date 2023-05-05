<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::sliders.index')" />
        <x-admin::page-title value="Buat Slider" />
    </div>

    <x-admin::form-container>
        <form action="{{ route('admin::sliders.store') }}" method="POST">
            @csrf
            <x-admin::sliders.form />
            <x-admin::button variant="primary" type="submit" value="Simpan" />
        </form>
    </x-admin::form-container>
</x-admin::app>
