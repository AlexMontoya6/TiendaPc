<x-app-layout>
    <div class="flex">
        <!-- Sidebar con Livewire -->
        @livewire('partials.admin-sidebar')

        <!-- Contenido Principal -->
        <div class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4">Panel de Administración</h1>

            <!-- Aquí se insertará el contenido de cada sección -->
            {{ $slot }}
        </div>
    </div>
</x-app-layout>

