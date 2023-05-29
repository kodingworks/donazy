<x-app>
    <x-search-bar />

    <x-container>
        <main class="py-20">
            <x-bg-main class="p-4">
                @switch($transaction->status)
                @case(\App\Models\Transaction::STATUS_WAITING)
                        <x-transactions.waiting :transaction="$transaction" :paymentMethod="$paymentMethod" />
                        @break
                    @case(\App\Models\Transaction::STATUS_PAID)
                        <x-transactions.paid :transaction="$transaction" :paymentMethod="$paymentMethod" />
                        @break
                    @case(\App\Models\Transaction::STATUS_EXPIRED)
                        <x-transactions.expired :transaction="$transaction" :paymentMethod="$paymentMethod" />
                        @break
                    @case(\App\Models\Transaction::STATUS_CANCELED)
                        <x-transactions.canceled :transaction="$transaction" :paymentMethod="$paymentMethod" />
                        @break
                @endswitch
            </x-bg-main>
        </main>
    </x-container>

    <x-bottom-bar />
</x-app>
