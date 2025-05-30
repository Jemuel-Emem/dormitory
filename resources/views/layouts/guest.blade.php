<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BH DIRECTORY</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->

</head>
<body class="font-sans text-gray-900 antialiased bg-cover bg-center bg-fixed bg-no-repeat" style="background-image: url('{{ asset('images/bg.jpg') }}');">
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-900/50 backdrop-blur-sm">
        <div class="flex flex-col items-center space-y-4">
            <a href="/" wire:navigate>
                <img src="{{ asset('images/logo.png') }}" class="w-24 h-24 border-4 border-white rounded-full shadow-lg" alt="Logo">
            </a>
            <h1 class="text-3xl font-semibold text-white">DORMITORY DIRECTORY</h1>
        </div>

        <div class="w-fit mt-6 px-8 py-6 bg-white bg-opacity-90 shadow-lg rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>


</body>
</html>
