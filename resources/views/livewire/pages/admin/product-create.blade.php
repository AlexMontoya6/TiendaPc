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
                <label for="slug" class="block text-gray-700">Slug</label>
                <input type="text" id="slug" wire:model="slug" class="w-full p-2 border rounded">
                @error('slug')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
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
