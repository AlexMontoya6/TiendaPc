<div class="relative">
    <!-- Botón de colapsar -->
    <button wire:click="toggleSidebar"
        class="absolute right-[-12px] top-4 bg-gray-300 text-gray-700 p-2 rounded-full focus:outline-none transition-all duration-300">
        {{ $collapsed ? '➡️' : '⬅️' }}
    </button>

    <!-- Sidebar -->
    <nav class="bg-white text-gray-800 h-screen border-r border-gray-200 shadow-sm transition-all duration-300 ease-in-out"
        :class="{ 'w-64': !@js($collapsed), 'w-16': @js($collapsed) }">

        <div class="flex items-center justify-center h-16 border-b border-gray-300">
            <h1 class="text-lg font-semibold transition-all duration-300"
                :class="{ 'hidden': @js($collapsed), 'block': !@js($collapsed) }">
                Administración
            </h1>
        </div>

        <div class="flex flex-col mt-4 space-y-2">
            <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')"
                class="px-4 py-3 hover:bg-gray-100 flex items-center transition-all duration-300">
                📊 <span
                    :class="{ 'hidden': @js($collapsed), 'inline-block ml-2': !@js($collapsed) }">Dashboard</span>
            </x-nav-link>

            <x-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.index')"
                class="px-4 py-3 hover:bg-gray-100 flex items-center transition-all duration-300">
                👤 <span
                    :class="{ 'hidden': @js($collapsed), 'inline-block ml-2': !@js($collapsed) }">Usuarios</span>
            </x-nav-link>

            <x-nav-link href="{{ route('admin.products.index') }}" :active="request()->routeIs('admin.products.index')"
                class="px-4 py-3 hover:bg-gray-100 flex items-center transition-all duration-300">
                🛒 <span
                    :class="{ 'hidden': @js($collapsed), 'inline-block ml-2': !@js($collapsed) }">Productos</span>
            </x-nav-link>

            <x-nav-link href=""
                class="px-4 py-3 hover:bg-gray-100 flex items-center transition-all duration-300">
                📦 <span
                    :class="{ 'hidden': @js($collapsed), 'inline-block ml-2': !@js($collapsed) }">Pedidos</span>
            </x-nav-link>
        </div>
    </nav>
</div>
