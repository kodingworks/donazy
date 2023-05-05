@props(['transaction', 'paymentMethod'])

<div>
    <h3 class="text-center text-primary text-xl font-bold mb-4">Jazaakumullahu Khairan</h3>
    <p class="text-center text-sm mb-5">Alhamdulillah donasi anda telah diterima!</p>
    <img
        src="{{ $transaction->campaign->original_cover_url }}"
        alt="{{ $transaction->campaign->name }}"
        class="mx-auto w-2/3 mb-5"
    />
    <p class="font-bold mb-1">Program</p>
    <p class="text-sm mb-4">{{ $transaction->campaign->name }}</p>
    <div class="mb-4 border border-gray-200"></div>
    <div class="flex items-center justify-between text-sm mb-4">
        <p>Total Donasi</p>
        <p class="font-bold">@idr($transaction->total)</p>
    </div>
    <div class="mb-4"></div>
    <a href="{{ route('campaigns.index') }}" class="block bg-white text-center text-primary font-semibold border-2 border-primary px-4 py-3 uppercase">Tambah Donasi</a>
    <div class="mb-4"></div>
    <div class="mb-4"></div>
    <div class="px-4 mb-4 text-center text-sm">
        <p>Semoga donasi dan dukungan yang anda berikan menjadi amal ibadah yang diterima disisi Allah Subhanahu Wa Ta’ala.</p>
        <p>Aamiin Allahumma Aamiin.</p>
    </div>
    <p class="text-center text-sm">Butuh bantuan? <a href="#" class="text-primary font-bold">Hubungi kami</a></p>
</div>
