<x-app-guest>
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-label for="name" value="Nama" />

            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-label for="email" value="Email" />

            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
        </div>

        <div class="mt-4">
            <x-label for="phone" value="Nomor HP" />

            <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-label for="password" value="Kata Sandi" />

            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-label for="password_confirmation" value="Konfirmasi Kata Sandi" />

            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">Sudah terdaftar?</a>

            <x-button type="submit" class="ml-4">Daftar</x-button>
        </div>
    </form>
</x-app-guest>
