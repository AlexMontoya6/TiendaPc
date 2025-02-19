<x-app-layout>
    <div class="flex">
        <!-- Sidebar con Livewire -->
        @livewire('partials.admin-sidebar')
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Gestión de Productos</h1>

            {{-- Livewire manejará la búsqueda, pero los productos y la paginación vienen desde Blade --}}
            <livewire:product-list :products="$products->items()" />

            {{-- Mostramos los botones de paginación debajo del componente --}}
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>

</x-app-layout>
