@if (session()->has('success'))
    <x-alert :message="session('success')" type="success" />
@endif
