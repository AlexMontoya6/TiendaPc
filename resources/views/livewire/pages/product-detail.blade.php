<div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Galería de imágenes del producto -->
        <div x-data="{ activeImage: '{{ asset('storage/' . $images->first()->path ?? 'placeholder.png') }}' }">
            <!-- Imagen principal -->
            <img :src="activeImage" alt="{{ $product->name }}"
                class="w-full h-[400px] object-contain rounded-lg shadow-md transition-opacity duration-300">

            <!-- Miniaturas -->
            <div class="flex gap-2 mt-4">
                @foreach ($images as $image)
                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}"
                        class="w-16 h-16 object-cover rounded-md cursor-pointer border-2 border-transparent hover:border-blue-500 transition-all"
                        @mouseover="activeImage = '{{ asset('storage/' . $image->path) }}'">
                @endforeach
            </div>
        </div>

        <!-- Información del producto -->
        <div>

            <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>

            <x-product-tags :product="$product" />

            <p class="text-gray-600 mt-2">{{ $product->description }}</p>

            <div class="mt-4">
                <span class="text-2xl font-semibold text-blue-600">{{ $product->getFormattedPriceAttribute() }}
                    €</span>
            </div>

            <div class="mt-4">
                <span class="text-sm text-gray-500">Stock disponible: {{ $product->stock }}</span>
            </div>

            <div class="mt-6">
                <button wire:click="$dispatch('addToCart', { productId: {{ $product->id }} })"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                    🛒 Añadir al carrito
                </button>
            </div>

            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Reseñas del producto -->
    <div class="mt-10">
        <h2 class="text-2xl font-semibold">Reseñas</h2>
        <p class="text-gray-500">Aquí puedes mostrar comentarios y calificaciones de clientes.</p>
    </div>
</div>
