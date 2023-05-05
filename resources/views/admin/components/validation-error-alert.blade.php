@if ($errors->isNotEmpty())
    <x-admin::alert :message="__('The given data was invalid.')" type="error" />
@endif
