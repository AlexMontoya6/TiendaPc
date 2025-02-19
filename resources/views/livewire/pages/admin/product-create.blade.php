<div class="flex">

    @livewire('partials.admin-sidebar')

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded">
        <h2 class="text-lg font-semibold mb-4">Nuevo Producto</h2>

        @if (session()->has('success'))
            <div class="p-2 bg-green-200 text-green-700 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="save">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nombre</label>
                <input type="text" id="name" wire:model="name" class="w-full p-2 border rounded">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <input type="file" wire:model="images" multiple accept="image/*" class="border p-2 rounded">
                @error('images.*')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror

                <!-- Vista previa de imágenes -->
                @if (!empty($images))
                    <div class="flex mt-2 space-x-2">
                        @foreach ($images as $image)
                            @if (is_object($image)) {{-- Solo muestra imágenes si son archivos --}}
                                <img src="{{ $image->temporaryUrl() }}" class="w-16 h-16 object-cover rounded">
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>



            <div class="mb-4">
                <label for="description" class="block text-gray-700">Descripción</label>
                <textarea id="description" wire:model="description" class="w-full p-2 border rounded"></textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-700">Precio (€)</label>
                <input type="number" id="price" wire:model="price" class="w-full p-2 border rounded"
                    step="0.01">
                @error('price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Guardar Producto
            </button>
        </form>
    </div>
</div>
