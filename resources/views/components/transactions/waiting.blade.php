@props(['transaction', 'paymentMethod'])

<div>
    <h3 class="text-center text-primary text-xl font-bold mb-4">Jazaakumullahu Khairan</h3>
    <p class="text-center text-sm mb-8 w-2/3 mx-auto">Satu langkah lagi untuk berdonasi program pilihan anda :</p>
    <p class="font-bold mb-1">Program</p>
    <p class="mb-4 text-sm">{{ $transaction->campaign->name }}</p>
    <div class="mb-4 border border-gray-200"></div>
    <div class="flex items-center justify-between text-sm mb-4">
        <p>Nominal Donasi</p>
        <p>@idr($transaction->amount)</p>
    </div>
    <div class="mb-4 border border-gray-200"></div>
    <div class="flex items-center justify-between text-sm mb-4">
        <p>Kode Unik</p>
        <p>@idr($transaction->unique_code)</p>
    </div>
    <div
        x-data="TransferTotal()"
        class="p-4 mb-4 rounded border border-gray-200 flex flex-col items-center"
    >
        <p class="text-sm">Total Donasi Anda</p>
        <p class="font-semibold text-lg">@idr($transaction->total)</p>
        <button
            type="button"
            x-on:click="copyToClipboard"
            class="text-primary text-sm focus:outline-none"
        >
            <span x-show="!showFeedback">Salin</span>
            <span x-show="showFeedback">Tersalin</span>
        </button>
    </div>
    <script>
        function TransferTotal() {
            return {
                value: '{{ $transaction->total }}',
                showFeedback: false,
                copyToClipboard() {
                    var tempInput = document.createElement('input');
                    tempInput.value = this.value;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);

                    this.showFeedback = true;

                    setTimeout(() => this.showFeedback = false, 1000);
                }
            };
        };
    </script>
    <div
        x-data="PaymentMethod()"
        class="p-4 mb-4 rounded border border-gray-200 flex flex-col items-center"
    >
        <p class="text-sm">Metode Pembayaran</p>
        <p>{{ $paymentMethod->name }}</p>
        <p class="text-sm">{{ $paymentMethod->account_holder_name }}</p>
        <p class="font-semibold text-lg">{{ $paymentMethod->account_number }}</p>
        <button
        type="button"
        x-on:click="copyToClipboard"
        class="text-primary text-sm focus:outline-none"
        >
        <span x-show="!showFeedback">Salin</span>
        <span x-show="showFeedback">Tersalin<span>
        </button>
    </div>
    <script>
        function PaymentMethod() {
            return {
                value: '{{ $paymentMethod->account_number }}',
                showFeedback: false,
                copyToClipboard() {
                    var tempInput = document.createElement('input');
                    tempInput.value = this.value;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);

                    this.showFeedback = true;

                    setTimeout(() => this.showFeedback = false, 1000);
                }
            };
        };
    </script>
    <div class="p-4 mb-4 flex items-center space-x-2 bg-green-100 rounded">
        <div class="px-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="font-semibold">PENTING</p>
            <p>Mohon transfer sesuai dengan nominal total donasi.</p>
        </div>
    </div>
    <p class="px-4 mb-4 text-center text-sm">Donasi anda akan terverifikasi oleh sistem secara otomatis maksimal <span class="font-bold">30 menit.</span></p>
    <div class="px-8 mb-4 text-gray-400">
        <p class="text-center text-sm">Anda akan mendapatkan notifikasi via email apabila donasi anda telah diterima.</p>
        <p class="text-center text-sm">Baarakallahu fiikum.</p>
    </div>
    <p class="text-center text-sm">Butuh bantuan? <a href="#" class="text-primary font-bold">Hubungi kami</a></p>
</div>
