@if (session()->has('success'))
    <x-admin::alert :message="session('success')" type="success" />
@endif
