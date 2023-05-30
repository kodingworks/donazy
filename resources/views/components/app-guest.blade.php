<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="vapid-key" content="{{ config('webpush.vapid.public_key') }}">
    <meta name="subscription">
    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">

    <link rel="icon" href="favicon.png" type="image/x-icon">
    <link rel="manifest" href="/manifest.json">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</head>

<body class="font-sans antialiased bg-gray-50">
    <x-loading />

    <x-container class="pt-24">
        <div class="w-full p-4 flex justify-center">
            <img src="https://i.ibb.co/F7K52H7/donazy-logo-rounded.png" alt="{{ Config::get('app.name') }}" class="h-20">
        </div>
        <x-bg-main class="w-full p-4">
            {!! $slot !!}
        </x-bg-main>
    </x-container>
</body>

</html>
