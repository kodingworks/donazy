<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::users.index')" />
        <x-admin::page-title value="Buat Pengguna" />
    </div>

    <x-admin::form-container>
        <form action="{{ route('admin::users.store') }}" method="POST">
            @csrf
            <x-admin::users.form />
            <x-admin::button variant="primary" type="submit" value="Simpan" />
        </form>
    </x-admin::form-container>
</x-admin::app>
