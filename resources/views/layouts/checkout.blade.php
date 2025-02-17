<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - {{ config('app.name', 'Laravel') }}</title>

    <!-- Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100">

    <!-- Barra de progreso del Checkout -->
    <div class="max-w-4xl mx-auto mt-6">
        <div class="flex justify-between items-center">
            @php
                $steps = [
                    ['ruta' => 'cart.index', 'titulo' => 'Mi carrito'],
                    ['ruta' => 'cart.checkout.envio', 'titulo' => 'Dirección de envío'],
                    ['ruta' => 'cart.checkout.entrega', 'titulo' => 'Opciones de entrega'],
                    ['ruta' => 'cart.checkout.resumen_pago', 'titulo' => 'Resumen y Pago'],
                ];

            @endphp

            @foreach ($steps as $index => $step)
                @php
                    $activo = request()->routeIs($step['ruta']);
                @endphp
                <div class="flex flex-col items-center">
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full
                        {{ $activo ? 'bg-black text-white' : 'bg-gray-300 text-gray-600' }}">
                        {{ $index + 1 }}
                    </div>
                    <span class="{{ $activo ? 'font-bold text-black' : 'text-gray-500' }}">
                        {{ $step['titulo'] }}
                    </span>
                </div>
                @if (!$loop->last)
                    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Contenido del Checkout -->
    <div class="max-w-4xl mx-auto py-8">
        {{ $slot }}
    </div>


    @livewireScripts
</body>

</html>
