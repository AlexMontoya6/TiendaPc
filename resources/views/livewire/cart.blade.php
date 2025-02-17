<div x-data="{ open: false }">
    <!-- Botón para abrir el carrito -->
    <button @click="open = true" class="relative ml-4 mr-4" >
        🛒
        <span class="absolute -top-3 -right-2 bg-red-700 text-white text-xs rounded-full px-1">
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
                <div class="flex justify-between mb-2 border-b pb-2 items-center">
                    <!-- Nombre del producto -->
                    <span class="font-medium">{{ $item['name'] }}</span>
                    <div class="flex items-center gap-2">
                        <!-- Precio del producto -->
                        <span class="text-gray-700">${{ number_format($item['subtotal'] / 100, 2) }}</span>
                        <!-- Botón para eliminar producto -->
                        <button wire:click="removeFromCart('{{ $item['id'] }}')" class="text-red-500 hover:text-red-700">
                            🗑️
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Tu carrito está vacío.</p>
            @endforelse
        </div>

        <div class="p-4 border-t">
            <a href="{{ route('cart.index') }}" class="w-full block text-center bg-blue-500 text-white py-2 rounded hover:bg-blue-700">
                Ir al Carrito
            </a>
        </div>


    </div>
</div>
