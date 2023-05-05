<x-admin::app>
    <x-admin::page-title value="Transaksi" />

    <x-admin::success-alert />

    <div class="flex justify-between items-center space-x-2 rounded-lg mb-4">
        <div>
            <form action="{{ route('admin::transactions.index') }}" method="GET">
                <x-admin::search />
            </form>
        </div>
        <div>
            <x-admin::button
                variant="secondary"
                onclick="window.location.href = '{{ route('admin::transactions.index', ['action' => 'export']) }}'"
            >
                Ekspor
            </x-admin::button>
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
                        <x-admin::sortable value="Kode" name="code" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Program" name="campaign_name" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Nama" name="user_name" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Total" name="total" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Waktu Dibuat" name="created_at" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Status" name="status" />
                    </x-admin::row-header>
                    <x-admin::row-header>Aksi</x-admin::row-header>
                </x-admin::col-header>
            </thead>
            <x-admin::tbody>
                @forelse ($transactions as $transaction)
                    <x-admin::col>
                        <x-admin::row>{{ $transaction->id }}</x-admin::row>
                        <x-admin::row>{{ $transaction->code }}</x-admin::row>
                        <x-admin::row>{{ $transaction->campaign_name }}</x-admin::row>
                        <x-admin::row>{{ $transaction->user_name }}</x-admin::row>
                        <x-admin::row>@idr($transaction->total)</x-admin::row>
                        <x-admin::row>{{ $transaction->created_at }}</x-admin::row>
                        <x-admin::row>{{ $transaction->status }}</x-admin::row>
                        <x-admin::row>
                            <div class="flex items-center text-sm">
                                <x-admin::row-show-action :href="route('admin::transactions.show', $transaction)" />
                            </div>
                        </x-admin::row>
                    </x-admin::col>
                @empty
                    <x-admin::col>
                        <x-admin::row colspan="8">
                            <x-admin::empty />
                        </x-admin::row>
                    </x-admin::col>
                @endforelse
            </x-admin::tbody>
        </x-admin::table>

        <x-admin::pagination :collection="$transactions" />
    </div>

</x-admin::app>
