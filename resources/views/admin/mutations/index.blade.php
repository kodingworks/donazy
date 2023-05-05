<x-admin::app>
    <x-admin::page-title value="Mutasi" />

    <div class="flex justify-between items-center space-x-2 rounded-lg mb-4">
        <div>
            <form action="{{ route('admin::mutations.index') }}" method="GET">
                <x-admin::search />
            </form>
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
                        <x-admin::sortable value="Tanggal Diterima" name="received_at" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Nomor Rekening" name="account_number" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Atas Nama" name="account_holder_name" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Deskripsi" name="description" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Tipe" name="type" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Nominal" name="amount" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Saldo Terakhir" name="balance" />
                    </x-admin::row-header>
                </x-admin::col-header>
            </thead>
            <x-admin::tbody>
                @forelse ($mutations as $mutation)
                    <x-admin::col>
                        <x-admin::row>{{ $mutation->id }}</x-admin::row>
                        <x-admin::row>{{ $mutation->received_at }}</x-admin::row>
                        <x-admin::row>{{ $mutation->account_number }}</x-admin::row>
                        <x-admin::row>{{ $mutation->account_holder_name }}</x-admin::row>
                        <x-admin::row>{{ $mutation->description }}</x-admin::row>
                        <x-admin::row>{{ $mutation->type }}</x-admin::row>
                        <x-admin::row>@idr($mutation->amount)</x-admin::row>
                        <x-admin::row>@idr($mutation->balance)</x-admin::row>
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

        <x-admin::pagination :collection="$mutations" />
    </div>

</x-admin::app>
