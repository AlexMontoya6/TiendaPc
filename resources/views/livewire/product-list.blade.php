<div>
    <div class="mb-4 flex justify-between items-center">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Buscar productos..."
            class="border p-2 rounded w-1/3 text-sm">

        <a href="{{ route('admin.products.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">
            Nuevo Producto
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300 text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Imagen</th>
                    <th class="border p-2">Nombre</th>
                    <th class="border p-2">Precio</th>
                    <th class="border p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border">
                        <td class="p-2 text-center">{{ $product->id }}</td>
                        <td class="p-2 text-center">
                            @if ($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->path) }}"
                                    alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded mx-auto">
                            @else
                                <span class="text-gray-500">Sin imagen</span>
                            @endif
                        </td>
                        <td class="p-2">{{ $product->name }}</td>
                        <td class="p-2 text-center">{{ number_format($product->price / 100, 2) }} €</td>
                        <td class="p-2 flex justify-center space-x-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Editar
                            </a>
                            <button wire:click="$emit('deleteProduct', {{ $product->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
