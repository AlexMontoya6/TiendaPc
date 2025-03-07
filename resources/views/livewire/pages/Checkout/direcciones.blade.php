<div>
    <!-- Lista de direcciones -->
    <h1 class="text-2xl font-bold mb-4">Selecciona tu dirección de envío</h1>

    @if ($addresses->isEmpty())
        <p class="text-gray-500">No tienes direcciones guardadas. Agrega una nueva para continuar.</p>
    @else
        <ul>
            @foreach ($addresses as $address)
                <li
                    class="p-4 border rounded-lg mb-2 flex justify-between items-center {{ $address->is_default ? 'bg-blue-100' : '' }}">
                    <div>
                        <p><strong>{{ $address->name }}</strong></p>
                        <p>{{ $address->street }}, {{ $address->city }}, {{ $address->postal_code }},
                            {{ $address->country }}</p>
                        <button wire:click="setDefaultAddress({{ $address->id }})"
                            class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Seleccionar
                        </button>
                    </div>
                    <button
                        onclick="confirm('¿Estás seguro de eliminar esta dirección?') || event.stopImmediatePropagation()"
                        wire:click="deleteAddress({{ $address->id }})"
                        class="bg-red-500 text-white p-2 rounded-full hover:bg-red-700">
                        <!-- Ícono de papelera (Heroicons o FontAwesome) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a1 1 0 011-1h2a1 1 0 011 1h5a1 1 0 110 2h-1v10a2 2 0 01-2 2H5a2 2 0 01-2-2V6H2a1 1 0 110-2h5zm3 2H9v10h2V6z"
                                clip-rule="evenodd" />
                        </svg>
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
