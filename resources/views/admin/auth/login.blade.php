<x-admin::guest>
    <div class="flex flex-col overflow-y-auto md:flex-row">
        <div class="h-32 md:h-auto md:w-1/2">
            <img aria-hidden="true" class="object-contain w-full h-full" src="https://i.ibb.co/F7K52H7/donazy-logo-rounded.png" alt="{{ config('app.name') }}" />
        </div>
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
                <form action="{{ route('admin::auth.login') }}" method="POST">
                    @csrf
                    <x-admin::page-title :value="'Admin Panel ' . config('app.name')" class="text-center" />
                    <label class="block text-sm mb-4">
                        <x-admin::label value="Email" />
                        <x-admin::input type="email" name="email" :error="$errors->has('email')" :value="old('email')" autofocus />
                        @error('email')
                            <x-admin::input-helper error :value="$message" />
                        @enderror
                    </label>
                    <label class="block text-sm mb-4">
                        <x-admin::label value="Kata sandi" />
                        <x-admin::input type="password" name="password" :error="$errors->hasAny(['email', 'password'])" />
                        @if($errors->hasAny(['email', 'password']))
                            <x-admin::input-helper error :value="$errors->first()" />
                        @endif
                    </label>

                    <x-admin::button variant="primary" value="Masuk" class="w-full" />
                </form>
            </div>
        </div>
    </div>
</x-admin::guest>
