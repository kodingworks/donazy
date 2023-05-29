@props(['paymentMethod' => new \App\Models\PaymentMethod()])

<div>
    <label class="block text-sm mb-4">
        <x-admin::label value="Nama" required />
        <x-admin::input type="text" name="name" placeholder="Nama Bank" :error="$errors->has('name')"
            :value="old('name', $paymentMethod->name)" />
        @error('name')
            <x-admin::input-helper error :value="$message" />
        @enderror
    </label>
    <label class="block text-sm mb-4">
        <x-admin::label value="Nama Pemegang" required />
        <x-admin::input type="text" name="account_holder_name" placeholder="Nama Pemegang" :error="$errors->has('email')"
            :value="old('email', $paymentMethod->account_holder_name)" />
        @error('email')
            <x-admin::input-helper error :value="$message" />
        @enderror
    </label>
    <label class="block text-sm mb-4">
        <x-admin::label value="Nomor Rekening" required />
        <x-admin::input type="text" name="account_number" placeholder="Nomor Rekening" :error="$errors->has('phone')"
            :value="old('phone', $paymentMethod->account_number)" />
        @error('phone')
            <x-admin::input-helper error :value="$message" />
        @enderror
    </label>
</div>
