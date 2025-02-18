<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Resumen y Pago</h1>

    <!-- Dirección de Envío -->
    <div class="mb-4">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold">Dirección de Envío</h2>
            <button wire:click="$toggle('editingAddress')" class="text-blue-500 hover:text-blue-700">
                🖊️
            </button>
        </div>

        @if ($editingAddress)
            <livewire:pages.checkout.direcciones />
        @else
            <p>{{ $shipping_name }}</p>
            <p>{{ $shipping_street }}, {{ $shipping_city }}, {{ $shipping_postal_code }}, {{ $shipping_country }}</p>
        @endif
    </div>


    <!-- Método de Entrega -->
    <div class="mb-4">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold">Método de Entrega</h2>
            <button wire:click="$toggle('editingDelivery')" class="text-blue-500 hover:text-blue-700">
                🖊️
            </button>
        </div>

        @if ($editingDelivery)
            <livewire:pages.checkout.entrega />
        @else
            <p>
                @if ($delivery_method == 'standard')
                    Envío estándar (Gratis - 5-7 días)
                @elseif ($delivery_method == 'express')
                    Envío express (+5€, 24-48h)
                @endif
            </p>
        @endif
    </div>


    <!-- Resumen del Pedido -->
    <div class="mb-4">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold">Productos en tu Pedido</h2>
            <button wire:click="$toggle('editingCart')" class="text-blue-500 hover:text-blue-700">
                🖊️
            </button>
        </div>

        @if ($editingCart)
            <livewire:pages.cart />
        @else
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
                            <td class="p-2 text-right">{{ number_format($item['price'] * $item['qty'], 2) }}€</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="text-xl font-bold mt-4 text-right">Total: {{ number_format($cartTotal, 2) }}€</p>
        @endif
    </div>


    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Resumen y Pago</h1>

        <!-- Método de Pago -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Selecciona un método de pago</h2>

            <label class="flex items-center mt-2">
                <input type="radio" wire:model="payment_method" value="card" class="mr-2">
                <span>Tarjeta de crédito/débito</span>
            </label>

            <label class="flex items-center mt-2">
                <input type="radio" wire:model="payment_method" value="paypal" class="mr-2">
                <span>PayPal</span>
            </label>

            <label class="flex items-center mt-2">
                <input type="radio" wire:model="payment_method" value="bank_transfer" class="mr-2">
                <span>Transferencia bancaria</span>
            </label>
        </div>

        <!-- Condicional: Si el método de pago es PayPal, mostramos el formulario -->
        @if ($payment_method === 'paypal')
        <form id="payment-form" method="POST" action="{{ route('paypal.payment') }}">
            @csrf

            <!-- Enviar el total como input oculto -->
            <input type="hidden" name="price" value="{{ $cartTotal }}">

            <!-- Enviar nombre del producto -->
            <input type="hidden" name="product_name" value="{{ $cartItems[0]['name'] ?? 'Producto' }}">

            <!-- Enviar cantidad -->
            <input type="hidden" name="quantity" value="{{ $cartItems[0]['qty'] ?? 1 }}">

            <!-- Botón para confirmar y pagar -->
            <button type="submit"
                class="bg-yellow-500 text-white px-6 py-3 rounded hover:bg-yellow-600 w-full">
                Pagar con PayPal
            </button>
        </form>
        @else
            <!-- Botón genérico para otros métodos de pago -->
            <button wire:click="confirmOrder"
                class="bg-green-500 text-white px-6 py-3 rounded hover:bg-green-700 w-full">
                Confirmar y Pagar
            </button>
        @endif
    </div>

</div>
