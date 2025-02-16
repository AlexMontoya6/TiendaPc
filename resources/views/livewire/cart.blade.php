<div x-data="{ open: false }">
    <!-- Botón para abrir el carrito -->
    <button @click="open = true" class="relative ml-4 mr-4" >
        🛒
        <span class="absolute -top-3 -right-2 bg-red-500 text-white text-xs rounded-full px-2">
            {{ $cartCount }}
        </span>
    </button>

    <!-- Off-Canvas -->
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-50" @click="open = false"></div>
    <div x-show="open" class="fixed right-0 top-0 h-full w-80 bg-white shadow-lg z-50 transform transition-transform duration-300"
        x-transition:enter="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="translate-x-0"
        x-transition:leave-end="translate-x-full"
    >
        <div class="p-4 flex justify-between items-center border-b">
            <h2 class="text-lg font-bold">Carrito de Compras</h2>
            <button @click="open = false">❌</button>
        </div>

        <div class="p-4">
            @forelse($cartItems as $item)
                <div class="flex justify-between mb-2 border-b pb-2">
                    <span>{{ $item['name'] }}</span>
                    <span>${{ $item['subtotal'] / 100 }}</span>

                </div>
            @empty
                <p class="text-center text-gray-500">Tu carrito está vacío.</p>
            @endforelse
        </div>

        <div class="p-4 border-t">
            <button wire:click="checkout" class="w-full bg-blue-500 text-white py-2 rounded">Pagar</button>
        </div>
    </div>
</div>
