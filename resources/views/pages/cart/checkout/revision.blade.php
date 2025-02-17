@extends('layouts.checkout')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Resumen del Pedido</h1>

        <!-- Dirección de Envío -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Dirección de Envío</h2>
            <p>{{ session('shipping_name') }}</p>
            <p>{{ session('shipping_street') }}, {{ session('shipping_city') }}, {{ session('shipping_postal_code') }}, {{ session('shipping_country') }}</p>
        </div>

        <!-- Método de Entrega -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Método de Entrega</h2>
            <p>
                @if (session('delivery_method') == 'standard')
                    Envío estándar (Gratis - 5-7 días)
                @elseif (session('delivery_method') == 'express')
                    Envío express (+5€, 24-48h)
                @endif
            </p>
        </div>

        <!-- Método de Pago -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Método de Pago</h2>
            <p>
                @if (session('payment_method') == 'card')
                    Tarjeta de crédito/débito
                @elseif (session('payment_method') == 'paypal')
                    PayPal
                @elseif (session('payment_method') == 'bank_transfer')
                    Transferencia bancaria
                @endif
            </p>
        </div>

        <!-- Resumen del Carrito -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Productos en tu Pedido</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 text-left">Producto</th>
                        <th class="p-2 text-center">Cantidad</th>
                        <th class="p-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr class="border-t">
                            <td class="p-2">{{ $item['name'] }}</td>
                            <td class="p-2 text-center">{{ $item['qty'] }}</td>
                            <td class="p-2 text-right">{{ ($item['price'] * $item['qty']) }}€</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="text-xl font-bold mt-4 text-right">Total: {{ number_format($cartTotal / 100, 2) }}€</p>
        </div>

        <!-- Botón para confirmar el pedido -->
        <form method="POST" action="{{ route('cart.checkout.procesar') }}">
            @csrf
            <div class="mt-6">
                <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded hover:bg-green-700 w-full">
                    Confirmar Pedido
                </button>
            </div>
        </form>
    </div>
@endsection
