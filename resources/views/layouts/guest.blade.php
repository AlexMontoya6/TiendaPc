<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100">
    <!-- Barra de navegación -->
    @livewire('navigation-menu')



    <!-- Contenido principal -->
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
        {{ $slot }}
    </div>

    <!-- Scripts -->
    @livewireScripts
</body>
</html>
