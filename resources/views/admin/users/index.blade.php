<x-admin::app>
    <x-admin::page-title value="Pengguna" />

    <x-admin::success-alert />

    <div class="flex justify-between items-center space-x-2 rounded-lg mb-4">
        <div>
            <form action="{{ route('admin::users.index') }}" method="GET">
                <x-admin::search />
            </form>
        </div>
        <div>
            <x-admin::link variant="primary" :href="route('admin::users.create')" value="Buat" class="mt-1" />
        </div>
    </div>

    <div class="w-full overflow-hidden rounded-lg shadow-md">
        <x-admin::table>
            <thead>
                <x-admin::col-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="ID" name="id" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Nama" name="name" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Email" name="email" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Nomor HP" name="phone" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Waktu Dibuat" name="created_at" />
                    </x-admin::row-header>
                    <x-admin::row-header>Aksi</x-admin::row-header>
                </x-admin::col-header>
            </thead>
            <x-admin::tbody>
                @forelse ($users as $user)
                    <x-admin::col>
                        <x-admin::row>{{ $user->id }}</x-admin::row>
                        <x-admin::row>{{ $user->name }}</x-admin::row>
                        <x-admin::row>{{ $user->email }}</x-admin::row>
                        <x-admin::row>{{ $user->phone }}</x-admin::row>
                        <x-admin::row>{{ $user->created_at }}</x-admin::row>
                        <x-admin::row>
                            <div class="flex items-center text-sm">
                                <x-admin::row-show-action :href="route('admin::users.show', $user)" />
                                <x-admin::row-edit-action :href="route('admin::users.edit', $user)" />
                                <x-admin::row-delete-action :href="route('admin::users.destroy', $user)" />
                            </div>
                        </x-admin::row>
                    </x-admin::col>
                @empty
                    <x-admin::col>
                        <x-admin::row colspan="6">
                            <x-admin::empty />
                        </x-admin::row>
                    </x-admin::col>
                @endforelse
            </x-admin::tbody>
        </x-admin::table>
        <x-admin::pagination :collection="$users" />
    </div>
</x-admin::app>
