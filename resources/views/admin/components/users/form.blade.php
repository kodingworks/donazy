@props(['user' => new \App\Models\User()])

<div>
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
        <x-admin::label value="Kata Sandi" :required="empty($user->id)" />
        <x-admin::input type="password" name="password" placeholder="Kata Sandi"
            :error="$errors->has('password')" />
        @error('password')
            <x-admin::input-helper error :value="$message" />
        @enderror
    </label>
    <label class="block text-sm mb-4">
        <x-admin::label value="Konfirmasi Kata Sandi" :required="empty($user->id)" />
        <x-admin::input type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" />
    </label>
    <label class="block text-sm mb-4">
        <x-admin::label value="Tetapkan sebagai admin?" />
        <x-admin::checkbox label="Ya" name="admin" value="1" :checked="$user->isAdmin()" />
    </label>
</div>
