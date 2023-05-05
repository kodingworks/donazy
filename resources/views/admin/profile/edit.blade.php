<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::page-title value="Profil Saya" />
    </div>

    <x-admin::form-container>
        <form action="{{ route('admin::profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <label class="block text-sm mb-4">
                <x-admin::label value="Nama" required />
                <x-admin::input type="text" name="name" placeholder="Nama" :error="$errors->has('name')"
                    :value="old('name', $user->name)" />
                @error('name')
                    <x-admin::input-helper error :value="$message" />
                @enderror
            </label>
            <label class="block text-sm mb-4">
                <x-admin::label value="Email" required />
                <x-admin::input type="email" name="email" placeholder="Email" :error="$errors->has('email')"
                    :value="old('email', $user->email)" />
                @error('email')
                    <x-admin::input-helper error :value="$message" />
                @enderror
            </label>
            <label class="block text-sm mb-4">
                <x-admin::label value="Nomor HP" required />
                <x-admin::input type="text" name="phone" placeholder="Nomor HP" :error="$errors->has('phone')"
                    :value="old('phone', $user->phone)" />
                @error('phone')
                    <x-admin::input-helper error :value="$message" />
                @enderror
            </label>
            <label class="block text-sm mb-4">
                <x-admin::label value="Kata Sandi Sebelumnya" />
                <x-admin::input type="password" name="old_password" placeholder="Kata Sandi Sebelumnya"
                    :error="$errors->has('old_password')" />
                <x-admin::input-helper value="Biarkan kosong bila tidak ada perubahan" />
                @error('old_password')
                    <x-admin::input-helper error :value="$message" />
                @enderror
            </label>
            <label class="block text-sm mb-4">
                <x-admin::label value="Kata Sandi Baru" />
                <x-admin::input type="password" name="password" placeholder="Kata Sandi Baru"
                    :error="$errors->has('password')" />
                <x-admin::input-helper value="Biarkan kosong bila tidak ada perubahan" />
                @error('password')
                    <x-admin::input-helper error :value="$message" />
                @enderror
            </label>
            <label class="block text-sm mb-4">
                <x-admin::label value="Konfirmasi Kata Sandi" />
                <x-admin::input type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" />
                <x-admin::input-helper value="Biarkan kosong bila tidak ada perubahan" />
            </label>
            <x-admin::button variant="primary" type="submit" value="Simpan" />
        </form>
    </x-admin::form-container>
</x-admin::app>
