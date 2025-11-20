<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Secretaría</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/ec1d036121.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Forzar tema claro quitando cualquier clase 'dark' accidental
        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.remove('dark');
        });
    </script>

</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">

    @include('layouts.partials.secretaria.navigation')

    @include('layouts.partials.secretaria.sidebar')

    <div class="transition-all duration-300 pt-16">
        <div class="p-6">

            {{ $slot }}

        </div>
    </div>

    @include('layouts.partials.secretaria.sidebar-script')

</body>

</html>
