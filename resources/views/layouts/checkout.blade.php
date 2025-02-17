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
    <!-- Barra de progreso del Checkout -->
<div class="max-w-4xl mx-auto mt-6">
    <div class="flex justify-between items-center w-full">
        @php
            $steps = [
                ['ruta' => 'cart.index', 'titulo' => 'Mi carrito'],
                ['ruta' => 'cart.checkout.direcciones', 'titulo' => 'Dirección de envío'],
                ['ruta' => 'cart.checkout.entrega', 'titulo' => 'Opciones de entrega'],
                ['ruta' => 'cart.checkout.resumen_pago', 'titulo' => 'Resumen y Pago'],
            ];

            // Buscar el índice del paso actual en la lista de pasos
            $rutaActual = request()->route()->getName();
            $indicePasoActual = array_search($rutaActual, array_column($steps, 'ruta'));
        @endphp

        @foreach ($steps as $index => $step)
            @php
                // Si el índice del paso es menor al actual, está completado
                $completado = $index < $indicePasoActual;
                // Si el índice del paso es el actual
                $actual = $index === $indicePasoActual;
            @endphp

            <!-- Contenedor del paso -->
            <div class="flex items-center w-full">
                <!-- Círculo del paso -->
                <div class="w-10 h-10 flex items-center justify-center rounded-full
                    {{ $completado || $actual ? 'bg-black text-white' : 'bg-gray-300 text-gray-600' }}">
                    {{ $index + 1 }}
                </div>

                @if (!$loop->last)
                    <!-- Línea de conexión -->
                    <div class="flex-1 h-1 mx-2 relative">
                        <!-- Línea completa -->
                        <div class="absolute top-0 left-0 h-full w-full {{ $completado ? 'bg-black' : 'bg-gray-300' }}"></div>
                        <!-- Flecha progresiva -->
                        @if ($actual)
                            <div class="absolute top-0 left-0 h-full bg-black" style="width: 50%;"></div>
                        @endif
                    </div>
                @endif
            </div>
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
