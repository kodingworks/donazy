<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::users.index')" />
        <x-admin::page-title value="Ubah Pengguna" />
    </div>

    <x-admin::form-container>
        <form action="{{ route('admin::users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <x-admin::users.form :user="$user" />
            <x-admin::button variant="primary" type="submit" value="Simpan" />
        </form>
    </x-admin::form-container>
</x-admin::app>
