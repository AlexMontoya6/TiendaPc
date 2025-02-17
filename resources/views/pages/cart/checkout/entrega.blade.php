@extends('layouts.checkout')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Opciones de Entrega</h1>

        <form method="POST" action="{{ route('cart.checkout.delivery.store') }}">
            @csrf

            <div class="mb-4">
                <h2 class="text-lg font-semibold">Método de entrega</h2>

                <label class="flex items-center mt-2">
                    <input type="radio" name="delivery_method" value="standard" checked class="mr-2">
                    <span>Envío estándar (Gratis - 5-7 días)</span>
                </label>

                <label class="flex items-center mt-2">
                    <input type="radio" name="delivery_method" value="express" class="mr-2">
                    <span>Envío express (+5€, 24-48h)</span>
                </label>
            </div>

            <!-- Botón para continuar -->
            <div class="mt-6">
                <button type="submit" class="bg-black text-white px-6 py-3 rounded hover:bg-gray-800">
                    Continuar al Pago
                </button>
            </div>
        </form>
    </div>
@endsection
