@extends('layouts.checkout')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Carrito de Compras</h1>

        @if ($cartItems->isEmpty())
            <p class="text-gray-500 text-center">Tu carrito está vacío.</p>
            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700">
                    Seguir comprando
                </a>
            </div>
        @else
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 text-left">Producto</th>
                        <th class="p-2 text-center">Cantidad</th>
                        <th class="p-2 text-right">Precio</th>
                        <th class="p-2 text-right">Subtotal</th>
                        <th class="p-2 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr class="border-t">
                            <td class="p-2">
                                <p class="font-semibold">{{ $item['name'] }}</p>
                            </td>
                            <td class="p-2 text-center">
                                <input type="number" wire:model="quantities.{{ $item['id'] }}" min="1"
                                    class="w-16 text-center border rounded">
                            </td>
                            <td class="p-2 text-right">{{ number_format($item['price'] / 100, 2) }}€</td>
                            <td class="p-2 text-right">{{ number_format(($item['price'] * $item['qty']) / 100, 2) }}€</td>
                            <td class="p-2 text-right">
                                <button wire:click="removeFromCart('{{ $item['id'] }}')"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">
                                    🗑
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 text-right">
                <p class="text-xl font-bold">Total: {{ number_format($cartTotal / 100, 2) }}€</p>
                <div class="mt-4">
                    <a href="{{ route('cart.checkout.envio') }}"
                        class=" bg-black text-white px-6 py-3 rounded hover:bg-gray-800">
                        Continuar con el pedido
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
