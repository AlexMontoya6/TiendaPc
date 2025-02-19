<x-app-layout>
    <div class="flex">
        @livewire('partials.admin-sidebar')
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Crear Producto</h1>

            {{-- Formulario para crear un producto --}}
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                {{-- Nombre del producto --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre del producto</label>
                    <input type="text" name="name" id="name" required class="mt-1 p-2 w-full border rounded">
                </div>

                {{-- Descripción --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="description" id="description" class="mt-1 p-2 w-full border rounded"></textarea>
                </div>

                {{-- Precio --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Precio (€)</label>
                    <input type="number" name="price" id="price" required class="mt-1 p-2 w-full border rounded">
                </div>

                {{-- Componente Livewire para manejar los selects dinámicos --}}
                <livewire:product-form />

                {{-- Imágenes --}}
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700">Imágenes</label>
                    <input type="file" name="images[]" id="images" multiple
                        class="mt-1 p-2 w-full border rounded">
                </div>

                {{-- Botón de enviar --}}
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Guardar Producto
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
