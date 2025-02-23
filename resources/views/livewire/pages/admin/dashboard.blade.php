<div class="flex">
    <!-- Sidebar de Administración -->
    @livewire('partials.admin-sidebar')

    <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-4">Panel de Administración</h1>

        {{-- 🔹 Sección de Estadísticas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-bold">Total Productos</h2>
                <p class="text-3xl font-semibold">{{ $totalProducts }}</p>
            </div>
            <div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-bold">Usuarios Registrados</h2>
                <p class="text-3xl font-semibold">{{ $totalUsers }}</p>
            </div>
            <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-bold">Órdenes Pendientes</h2>
                <p class="text-3xl font-semibold">{{ $pendingOrders }}</p>
            </div>
        </div>

        {{-- 🔹 Últimos productos añadidos --}}
        <div class="mt-6">
            <h2 class="text-xl font-bold mb-2">Últimos Productos</h2>
            <div class="bg-white shadow-md rounded-lg p-4">
                <ul>
                    @foreach ($latestProducts as $product)
                        <li class="border-b py-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-500 hover:underline">
                                {{ $product->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</div>
