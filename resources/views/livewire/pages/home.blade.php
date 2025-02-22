<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Carrusel de Ofertas -->
        <h2 class="text-2xl font-bold mb-4 text-gray-900">🔥 Ofertas</h2>
        <div x-data="{ current: 0 }" class="relative w-full overflow-hidden">
            <div class="flex transition-transform duration-500" :style="'transform: translateX(-' + (current * 20) + '%)'">
                @foreach ($ofertaProducts as $product)
                    <div class="w-1/5 p-2 shrink-0">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <button @click="current = Math.max(current - 1, 0)" class="absolute left-0 top-1/2 -translate-y-1/2 bg-gray-800 text-white p-2">⬅</button>
            <button @click="current = Math.min(current + 1, {{ $ofertaProducts->count() - 5 }})" class="absolute right-0 top-1/2 -translate-y-1/2 bg-gray-800 text-white p-2">➡</button>
        </div>

        <!-- Carrusel de Trending -->
        <h2 class="text-2xl font-bold mt-8 mb-4 text-gray-900">🚀 Trending</h2>
        <div x-data="{ current: 0 }" class="relative w-full overflow-hidden">
            <div class="flex transition-transform duration-500" :style="'transform: translateX(-' + (current * 20) + '%)'">
                @foreach ($trendingProducts as $product)
                    <div class="w-1/5 p-2 shrink-0">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <button @click="current = Math.max(current - 1, 0)" class="absolute left-0 top-1/2 -translate-y-1/2 bg-gray-800 text-white p-2">⬅</button>
            <button @click="current = Math.min(current + 1, {{ $trendingProducts->count() - 5 }})" class="absolute right-0 top-1/2 -translate-y-1/2 bg-gray-800 text-white p-2">➡</button>
        </div>

        <!-- Carrusel de Portátiles -->
        <h2 class="text-2xl font-bold mt-8 mb-4 text-gray-900">💻 Portátiles</h2>
        <div x-data="{ current: 0 }" class="relative w-full overflow-hidden">
            <div class="flex transition-transform duration-500" :style="'transform: translateX(-' + (current * 20) + '%)'">
                @foreach ($portatilProducts as $product)
                    <div class="w-1/5 p-2 shrink-0">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <button @click="current = Math.max(current - 1, 0)" class="absolute left-0 top-1/2 -translate-y-1/2 bg-gray-800 text-white p-2">⬅</button>
            <button @click="current = Math.min(current + 1, {{ $portatilProducts->count() - 5 }})" class="absolute right-0 top-1/2 -translate-y-1/2 bg-gray-800 text-white p-2">➡</button>
        </div>

    </div>
</div>
