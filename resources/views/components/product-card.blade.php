<div class="bg-white shadow-lg rounded-lg overflow-hidden relative">
    <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}"
        class="w-full h-48 object-cover">
        <x-product-tags :product="$product" />
    <div class="p-4">
        <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
        <p class="text-gray-600 mt-2">{{ Str::limit($product->description, 50) }}</p>
        <div class="mt-4 flex justify-between items-center">
            <span class="text-xl font-bold text-black">{{ $product->getFormattedPriceAttribute() }} €</span>

            <a href="{{ route('product.detail', $product->slug) }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Ver más
            </a>

            <button wire:click="$dispatch('addToCart', { productId: {{ $product->id }} })"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                🛒 Añadir
            </button>
        </div>
    </div>
</div>
