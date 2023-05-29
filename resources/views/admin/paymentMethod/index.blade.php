<x-admin::app>
    <x-admin::page-title value="Metode Pembayaran" />

    <x-admin::success-alert />

    <div class="flex justify-between items-center space-x-2 rounded-lg mb-4">
        <div>
            <form action="{{ route('admin::paymentMethod.index') }}" method="GET">
                <x-admin::search />
            </form>
        </div>
        <div>
            <x-admin::link variant="primary" :href="route('admin::paymentMethod.create')" value="Buat" class="mt-1" />
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
                        <x-admin::sortable value="Nama Bank" name="name" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Nama Pemegang" name="account_holder_name" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Nomor Rekening" name="account_number" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Waktu Dibuat" name="created_at" />
                    </x-admin::row-header>
                    <x-admin::row-header>Aksi</x-admin::row-header>
                </x-admin::col-header>
            </thead>
            <x-admin::tbody>
                @forelse ($paymentMethods as $paymentMethod)
                    <x-admin::col>
                        <x-admin::row>{{ $paymentMethod->id }}</x-admin::row>
                        <x-admin::row>{{ $paymentMethod->name }}</x-admin::row>
                        <x-admin::row>{{ $paymentMethod->account_holder_name }}</x-admin::row>
                        <x-admin::row>{{ $paymentMethod->account_number }}</x-admin::row>
                        <x-admin::row>{{ $paymentMethod->created_at }}</x-admin::row>
                        <x-admin::row>
                            <div class="flex items-center text-sm">
                                <x-admin::row-edit-action :href="route('admin::paymentMethod.edit', $paymentMethod)" />
                                <x-admin::row-delete-action :href="route('admin::paymentMethod.destroy', $paymentMethod)" />
                            </div>
                        </x-admin::row>
                    </x-admin::col>
                @empty
                    <x-admin::col>
                        <x-admin::row colspan="5">
                            <x-admin::empty />
                        </x-admin::row>
                    </x-admin::col>
                @endforelse
            </x-admin::tbody>
        </x-admin::table>
        <x-admin::pagination :collection="$paymentMethods" />
    </div>
</x-admin::app>
