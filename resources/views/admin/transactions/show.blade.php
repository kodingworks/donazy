<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::transactions.index')" />
        <x-admin::page-title value="Detail Transaksi" />
    </div>

    <x-admin::card>
        <div class="mb-4">
            <x-admin::label value="Kode" />
            <p class="text-sm">{{ $transaction->code }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Program" />
            <p class="text-sm">{{ $transaction->campaign->name }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Nama" />
            <p class="text-sm">{{ $transaction->user_name }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Email" />
            <p class="text-sm">{{ $transaction->user_email }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Nomor HP" />
            <p class="text-sm">{{ $transaction->user_phone ?? '-' }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Pesan" />
            <p class="text-sm">{{ $transaction->message ?? '-' }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Nominal" />
            <p class="text-sm">@idr($transaction->amount)</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Kode Unik" />
            <p class="text-sm">{{ $transaction->unique_code }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Total" />
            <p class="text-sm">@idr($transaction->total)</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Waktu Dibuat" />
            <p class="text-sm">{{ $transaction->created_at }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Status" />
            @if ($transaction->status == \App\Models\Transaction::STATUS_WAITING)
                <form
                    action="{{ route('admin::transactions.statuses.update', $transaction) }}"
                    method="POST"
                    onsubmit="return confirm('Apakah anda yakin untuk mengubah status?')"
                    x-data="{ isDirty: false }"
                >
                    @csrf
                    @method('PUT')
                    <div class="inline-flex space-x-2">
                        <select
                            x-on:change="isDirty = $event.target.value != '{{ $transaction->status }}'"
                            name="status"
                            class="text-sm rounded focus:border-primary focus:shadow-outline-primary"
                        >
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @if($status == $transaction->status) selected @endif>{{ $status }}</option>
                            @endforeach
                        </select>
                        <x-admin::button
                            x-bind:disabled="!isDirty"
                            x-bind:class="{ 'opacity-50': !isDirty }"
                            variant="primary"
                            type="submit"
                            value="Ubah"
                        />
                    </div>
                </form>
            @else
                <p class="text-sm">{{ $transaction->status }}</p>
            @endif
        </div>
    </x-admin::card>
</x-admin::app>
