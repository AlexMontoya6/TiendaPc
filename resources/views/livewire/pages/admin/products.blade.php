<div class="flex">

        @livewire('partials.admin-sidebar')

    <div class="flex-1 max-w-6xl mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <input type="text" wire:model.debounce.300ms="search" placeholder="Buscar productos..."
                class="border p-2 rounded w-1/3 text-sm">
            <a href="{{ route('admin.products.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">Nuevo Producto</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Nombre</th>
                        <th class="border p-2">Precio</th>
                        <th class="border p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border">
                            <td class="p-2">{{ $product->id }}</td>
                            <td class="p-2">{{ $product->name }}</td>
                            <td class="p-2">{{ number_format($product->price / 100, 2) }} €</td>
                            <td class="p-2 flex space-x-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">Editar</a>
                                <button wire:click="delete({{ $product->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            {{ $products->links() }}
        </div>
    </div>
</div>
