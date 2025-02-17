<div>
    <!-- Lista de direcciones -->
    <h1 class="text-2xl font-bold mb-4">Selecciona tu dirección de envío</h1>

    @if ($addresses->isEmpty())
        <p class="text-gray-500">No tienes direcciones guardadas. Agrega una nueva para continuar.</p>
    @else
        <ul>
            @foreach ($addresses as $address)
                <li class="p-4 border rounded-lg mb-2 {{ $address->is_default ? 'bg-blue-100' : '' }}">
                    <p><strong>{{ $address->name }}</strong></p>
                    <p>{{ $address->street }}, {{ $address->city }}, {{ $address->postal_code }},
                        {{ $address->country }}</p>
                    <button wire:click="setDefaultAddress({{ $address->id }})"
                        class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Seleccionar
                    </button>
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Botón para mostrar/ocultar formulario -->
    <button wire:click="$toggle('showForm')" class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
        {{ $showForm ? 'Cancelar' : 'Agregar nueva dirección' }}
    </button>

    <!-- Formulario de nueva dirección (solo aparece si showForm es true) -->
    @if ($showForm)
        <div class="mt-4 p-4 border rounded bg-gray-100">
            <form wire:submit.prevent="save">
                <div class="mb-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" wire:model="name" class="mt-1 p-2 w-full border rounded" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="street" class="block text-sm font-medium text-gray-700">Calle y número</label>
                    <input type="text" wire:model="street" class="mt-1 p-2 w-full border rounded" required>
                    @error('street')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="city" class="block text-sm font-medium text-gray-700">Ciudad</label>
                    <input type="text" wire:model="city" class="mt-1 p-2 w-full border rounded" required>
                    @error('city')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Código Postal</label>
                    <input type="text" wire:model="postal_code" class="mt-1 p-2 w-full border rounded" required>
                    @error('postal_code')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="country" class="block text-sm font-medium text-gray-700">País</label>
                    <input type="text" wire:model="country" value="España" class="mt-1 p-2 w-full border rounded"
                        required>
                    @error('country')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-2 flex items-center">
                    <input type="checkbox" wire:model="is_default" class="mr-2">
                    <label class="text-sm font-medium text-gray-700">Marcar como dirección principal</label>
                </div>

                <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Guardar Dirección
                </button>
            </form>
        </div>
    @endif
    <!-- Botón para continuar -->
    <div class="mt-6">
        <button wire:click="continueToDelivery" class="bg-black text-white px-6 py-3 rounded hover:bg-gray-800">
            Continuar a Opciones de Entrega
        </button>
    </div>
</div>
