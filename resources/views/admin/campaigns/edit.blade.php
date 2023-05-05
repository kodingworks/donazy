<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::campaigns.index')" />
        <x-admin::page-title value="Ubah Program" />
    </div>

    <x-admin::form-container>
        <form action="{{ route('admin::campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-admin::campaigns.form :campaign="$campaign" />
            <x-admin::button variant="primary" type="submit" value="Simpan" />
        </form>
    </x-admin::form-container>

    <x-slot name="scripts">
        <script src="//cdn.ckeditor.com/4.16.1/standard/ckeditor.js" defer></script>
    </x-slot>
</x-admin::app>
