<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::users.index')" />
        <x-admin::page-title value="Detail Pengguna" />
    </div>

    <x-admin::card>
        <div class="mb-4">
            <x-admin::label value="Nama" />
            <p class="text-sm">{{ $user->name }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Email" />
            <p class="text-sm">{{ $user->email }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Nomor HP" />
            <p class="text-sm">{{ $user->phone }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Waktu Dibuat" />
            <p class="text-sm">{{ $user->created_at }}</p>
        </div>
        <div class="flex items-center space-x-2">
            <x-admin::link variant="primary" :href="route('admin::users.edit', $user)" value="Ubah" />
            <x-admin::button-delete :action="route('admin::users.destroy', $user)" />
        </div>
    </x-admin::card>
</x-admin::app>
