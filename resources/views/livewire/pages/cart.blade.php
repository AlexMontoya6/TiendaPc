<div class="container mx-auto p-6">
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
                            <p class="font-semibold">{{ $item->name }}</p>
                        </td>
                        <td class="p-2 text-center">
                            <input type="number" min="1" class="w-16 text-center border rounded"
                                wire:model.lazy="quantities.{{ $item->rowId }}"
                                wire:change="updateQuantity('{{ $item->rowId }}', $event.target.value)">
                        </td>

                        <td class="p-2 text-right">{{ number_format($item->price, 2) }}€</td>
                        <td class="p-2 text-right">{{ number_format($item->price * $item->qty, 2) }}€</td>
                        <td class="p-2 text-right">
                            <button onclick="confirm('¿Estás seguro de eliminar este producto?') || event.stopImmediatePropagation()"
                            wire:click="removeFromCart('{{ $item->rowId }}')"
                                class="bg-red-500 text-white p-2 rounded-full hover:bg-red-700">
                                <!-- Ícono de papelera (Heroicons o FontAwesome) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8 4a1 1 0 011-1h2a1 1 0 011 1h5a1 1 0 110 2h-1v10a2 2 0 01-2 2H5a2 2 0 01-2-2V6H2a1 1 0 110-2h5zm3 2H9v10h2V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6 text-right">
            <p class="text-xl font-bold">Total: {{ number_format($cartTotal, 2) }}€</p>
            <div class="mt-4">
                <a href="{{ route('cart.checkout.direcciones') }}"
                    class=" bg-black text-white px-6 py-3 rounded hover:bg-gray-800">
                    Continuar con el pedido
                </a>
            </div>
        </div>
    @endif
</div>
