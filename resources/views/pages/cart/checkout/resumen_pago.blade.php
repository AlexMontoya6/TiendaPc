@extends('layouts.checkout')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Resumen y Pago</h1>

        <!-- 🏠 Dirección de Envío -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Dirección de Envío</h2>
            <p>{{ session('shipping_name') }}</p>
            <p>{{ session('shipping_street') }}, {{ session('shipping_city') }}, {{ session('shipping_postal_code') }}, {{ session('shipping_country') }}</p>
        </div>

        <!-- 🚚 Método de Entrega -->
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

        <!-- 🛒 Resumen del Pedido -->
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

        <!-- 💳 Método de Pago -->
        <form method="POST" action="{{ route('cart.checkout.payment.store') }}">
            @csrf
            <div class="mb-4">
                <h2 class="text-lg font-semibold">Selecciona un método de pago</h2>

                <label class="flex items-center mt-2">
                    <input type="radio" name="payment_method" value="card" checked class="mr-2">
                    <span>Tarjeta de crédito/débito</span>
                </label>

                <label class="flex items-center mt-2">
                    <input type="radio" name="payment_method" value="paypal" class="mr-2">
                    <span>PayPal</span>
                </label>

                <label class="flex items-center mt-2">
                    <input type="radio" name="payment_method" value="bank_transfer" class="mr-2">
                    <span>Transferencia bancaria</span>
                </label>
            </div>

            <!-- ✅ Confirmar Pedido -->
            <div class="mt-6">
                <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded hover:bg-green-700 w-full">
                    Confirmar y Pagar
                </button>
            </div>
        </form>
    </div>
@endsection
