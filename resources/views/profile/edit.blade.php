<x-app>
    <header class="fixed top-0 inset-x-0 z-10">
        <x-bg-main>
            <x-container>
                <div class="flex items-center space-x-2 p-2">
                    <x-button-back href="/" />
                    <h3 class="line-clamp-1">Akun</h3>
                </div>
            </x-container>
        </x-bg-main>
    </header>

    <x-container>
        <main class="py-20">

            <x-bg-main class="p-4">
                <x-success-alert />

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <x-label for="name" value="Nama" required />

                        <x-input id="name" class="block mt-1 w-full" :error="$errors->has('name')" type="text" name="name" :value="old('name', $user->name)" required />
                        @error('name')
                            <x-input-helper error :value="$message" />
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="email" value="Email" required />

                        <x-input id="email" class="block mt-1 w-full" :error="$errors->has('email')" type="email" name="email" :value="old('email', $user->email)" required />
                        @error('email')
                            <x-input-helper error :value="$message" />
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="phone" value="Nomor HP" required />

                        <x-input id="phone" class="block mt-1 w-full" :error="$errors->has('phone')" type="text" name="phone" :value="old('phone', $user->phone)" required />
                        @error('phone')
                            <x-input-helper error :value="$message" />
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="old_password" value="Kata Sandi Sebelumnya" />

                        <x-input id="old_password" class="block mt-1 w-full" :error="$errors->has('old_password')" type="password" name="old_password" />
                        <x-input-helper value="Biarkan kosong bila tidak ada perubahan" />
                        @error('old_password')
                            <x-input-helper error :value="$message" />
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="password" value="Kata Sandi Baru" />

                        <x-input id="password" class="block mt-1 w-full" :error="$errors->has('password')" type="password" name="password" />
                        <x-input-helper value="Biarkan kosong bila tidak ada perubahan" />
                        @error('password')
                            <x-input-helper error :value="$message" />
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="password_confirmation" value="Konfirmasi Kata Sandi" />

                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                        <x-input-helper value="Biarkan kosong bila tidak ada perubahan" />
                    </div>

                    <x-button type="submit">Simpan</x-button>
                </form>
            </x-bg-main>

            <div class="mb-4"></div>

            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah anda yakin untuk keluar?')">
                @csrf
                <button
                    type="button"
                    onclick="document.getElementById('logout').click()"
                    class="block w-full py-2 px-3 rounded bg-primary text-white text-center font-semibold focus:outline-none"
                >Keluar</button>
                <input type="submit" id="logout" class="hidden"></input>
            </form>
        </main>
    </x-container>

    <x-bottom-bar />
</x-app>
