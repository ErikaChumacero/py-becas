<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Tutor - Sistema Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navbar -->
        @include('layouts.partials.tutor.navbar')

        <!-- Sidebar -->
        @include('layouts.partials.tutor.sidebar')

        <!-- Main Content -->
        <div class="p-4 sm:ml-64">
            <div class="p-4 mt-14">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
