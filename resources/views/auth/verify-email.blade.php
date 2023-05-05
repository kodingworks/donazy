<x-app-guest>
    <div class="mb-4 text-sm text-gray-600">
        Terima kasih sudah mendaftar. Sebelum memulai, bisakah anda verifikasi email anda terlebih dahulu dengan menekan tombok link yang sudah kami kirimkan. Jika anda belum menerima email tersbut, kami akan mengiriman kembali email tersebut.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            Alamat verifikasi sudah kami kiriman ke email anda.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-button type="submit">Kirim Ulang Alamat Verifikasi</x-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">Keluar</button>
        </form>
    </div>
</x-app-guest>
