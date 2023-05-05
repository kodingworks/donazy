<x-app-guest>
    <div class="mb-4 text-sm text-gray-600">Isi form berikut untuk pengajuan reset kata sandi</div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-label for="email" value="Email" />

            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button type="submit">Ajukan Reset Kata Sandi</x-button>
        </div>
    </form>
</x-app-guest>
