<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Productos Destacados</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden relative">

                    <!-- 🔹 Muestra las etiquetas del producto -->
                    @if ($product->tags->isNotEmpty())
                        <div class="absolute top-2 left-2 flex gap-2">
                            @foreach ($product->tags->where('pivot.is_active', true) as $tag)
                                <span
                                    class="px-2 py-1 text-sm font-semibold rounded border flex items-center justify-between gap-1"
                                    style="background-color: {{ $tag->background_color }};
                                   color: {{ $tag->text_color }};
                                   border-color: {{ $tag->border_color }};">
                                    {{ $tag->name }}
                                    <span class="ml-1 flex-shrink-0">{!! $tag->icon_svg !!}</span>
                                </span>
                            @endforeach
                        </div>
                    @endif

                    @if ($product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}"
                            class="w-full h-48 object-cover">
                    @else
                        <img src="https://via.placeholder.com/300" alt="Imagen no disponible"
                            class="w-full h-48 object-cover">
                    @endif

                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
                        <p class="text-gray-600 mt-2">{{ Str::limit($product->description, 60) }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xl font-bold text-blue-600">{{ $product->getFormattedPriceAttribute() }}
                                €</span>

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
            @endforeach
        </div>
        <div class="mt-6 flex justify-end">
            {{ $products->links() }}
        </div>
    </div>
</div>
