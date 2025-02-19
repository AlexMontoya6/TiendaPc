<x-app-layout>
    <div class="flex">
        @livewire('partials.admin-sidebar')

        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Gestión de Productos</h1>

            <livewire:product-list />

        </div>
    </div>

</x-app-layout>
