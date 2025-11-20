<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/ec1d036121.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.remove('dark');
        });
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    @include('layouts.partials.admin.navigation')
    @include('layouts.partials.admin.sidebar')
    
    <div class="pt-16 w-full">
        <div class="pt-6 pr-6 pb-6 pl-6 w-full">
            {{ $slot }}
        </div>
    </div>
    
    @include('layouts.partials.admin.sidebar-script')
</body>
</html>
