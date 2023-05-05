<x-app-guest>
    <div class="mb-4 text-sm text-gray-600">Mohon konfirmasi terlebih dahulu kata sandi anda.</div>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-label for="password" value="Kata Sandi" />

            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
        </div>

        <div class="flex justify-end mt-4">
            <x-button type="submit">Konfirmasi</x-button>
        </div>
    </form>
</x-app-guest>
