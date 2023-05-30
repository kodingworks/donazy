<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::paymentMethod.index')" />
        <x-admin::page-title value="Ubah Metode Pembayaran" />
    </div>

    <x-admin::form-container>
        <form action="{{ route('admin::paymentMethod.update', $paymentMethod) }}" method="POST">
            @csrf
            @method('PUT')
            <x-admin::PaymentMethod.form :paymentMethod="$paymentMethod" />
            <x-admin::button variant="primary" type="submit" value="Simpan" />
        </form>
    </x-admin::form-container>
</x-admin::app>
