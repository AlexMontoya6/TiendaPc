<x-app-layout>
    <div class="flex">
        <!-- Sidebar de Administración -->
        @livewire('partials.admin-sidebar')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">{{ __('Editar Usuario') }}</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong>{{ __('Oops! Algo salió mal.') }}</strong>
                <ul class="mt-2">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">{{ __('Nombre') }}:</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border border-gray-300 p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">{{ __('Email') }}:</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border border-gray-300 p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">{{ __('Nueva Contraseña (opcional)') }}:</label>
                <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">{{ __('Confirmar Nueva Contraseña') }}:</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">{{ __('Rol') }}:</label>
                <select name="role" class="w-full border border-gray-300 p-2 rounded">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ old('role', $user->roles->first()->name ?? 'Customer') == $role->name ? 'selected' : '' }}>
                            {{ __($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ __('Actualizar Usuario') }}
            </button>
        </form>
    </div>
</div>
</x-app-layout>
