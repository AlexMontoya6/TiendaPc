<x-app-layout>
    <div class="flex">
        @livewire('partials.admin-sidebar')
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Crear Producto</h1>

            {{-- 🔥 Mensaje global de error si la validación falla --}}
            @if(session('error'))
                <div class="bg-red-500 text-white p-2 rounded-md mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Formulario para crear un producto --}}
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                {{-- Nombre del producto --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre del producto</label>
                    <input type="text" name="name" id="name" required class="mt-1 p-2 w-full border rounded">
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="description" id="description" class="mt-1 p-2 w-full border rounded"></textarea>
                    @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Etiquetas --}}
                <livewire:components.admin.products.tag-selector />

                @error('tags') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                {{-- Precio --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Precio (€)</label>
                    <input type="number" name="price" id="price" required class="mt-1 p-2 w-full border rounded">
                    @error('price') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Componente Livewire para manejar los selects dinámicos --}}
                <livewire:components.admin.products.product-form />

                {{-- Imágenes --}}
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700">Imágenes</label>
                    <input type="file" name="images[]" id="images" multiple class="mt-1 p-2 w-full border rounded">
                    @error('images') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Botón de enviar --}}
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Guardar Producto
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
