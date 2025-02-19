<x-app-layout>
    <div class="flex">
        <!-- Sidebar de Administración -->
        @livewire('partials.admin-sidebar')

        <!-- Contenido Principal -->
        <div class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4">Lista de Usuarios</h1>

            <a href="{{ route('admin.users.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                ➕ Crear Usuario
            </a>

            <div class="mt-4">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <strong>✅ {{ session('success') }}</strong>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong>⚠️ {{ session('error') }}</strong>
                    </div>
                @endif
            </div>

            <table class="min-w-full bg-white border border-gray-300 mt-4">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 border">ID</th>
                        <th class="py-2 px-4 border">Nombre</th>
                        <th class="py-2 px-4 border">Email</th>
                        <th class="py-2 px-4 border">Rol</th>
                        <th class="py-2 px-4 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="py-2 px-4 border">{{ $user->id }}</td>
                            <td class="py-2 px-4 border">{{ $user->name }}</td>
                            <td class="py-2 px-4 border">{{ $user->email }}</td>
                            <td class="py-2 px-4 border text-center">
                                @can('update', $user)
                                    <form action="{{ route('admin.users.update-role', $user) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" onchange="this.form.submit()" class="border rounded px-2 py-1">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                @else
                                    <span class="text-gray-600">{{ $user->roles->first()->name ?? 'Sin rol' }}</span>
                                @endcan
                            </td>
                            <td class="py-2 px-4 border text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">✏️ Editar</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                                            onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                                            🗑 Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $users->links() }} <!-- Paginación -->
            </div>
        </div>
    </div>
</x-app-layout>
