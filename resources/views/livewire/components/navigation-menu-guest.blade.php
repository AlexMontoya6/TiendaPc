<div x-data="{
    open: false,
    subOpen: false,
    selectProduct(id) {
        this.subOpen = true;
        $wire.selectProductType(id);
    }
}"
@keydown.window.escape="open = false; subOpen = false">

<!-- Botón para abrir el menú lateral -->
<button @click="open = true" class="p-2">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343">
        <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/>
    </svg>
</button>

<!-- Overlay oscuro para cerrar al hacer clic fuera -->
<div x-show="open" class="fixed inset-0 bg-black opacity-50" @click="open = false; subOpen = false"></div>

<!-- Menú lateral principal -->
<div class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg z-50 transform transition-transform duration-300"
     x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="-translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="-translate-x-full"
     @click.outside="if (!subOpen) { open = false; }"> <!-- 🔥 Cierra solo si NO hay submenú abierto -->

    <div class="p-4 flex justify-between items-center border-b">
        <!-- X a la izquierda -->
        <button @click="open = false; subOpen = false" class="text-gray-500">&times;</button>
        <h2 class="text-lg font-bold ml-2">Categorías</h2>
    </div>

    <ul class="p-4 space-y-2">
        @foreach ($productTypes as $type)
            <li>
                <button @click="selectProduct({{ $type->id }})"
                        class="w-full text-left px-2 py-1 rounded hover:bg-gray-200">
                    {{ $type->name }} &rsaquo;
                </button>
            </li>
        @endforeach
    </ul>
</div>

<!-- Submenú de categorías -->
<div class="fixed top-0 left-64 w-64 h-full bg-gray-100 shadow-lg z-50 transform transition-transform duration-300"
     x-show="subOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="-translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="-translate-x-full"
     @click.outside="subOpen = false"> <!-- 🔥 Ahora solo cierra el submenú cuando haces clic FUERA -->

    <div class="p-4 flex items-center border-b">
        <h2 class="text-lg font-bold">{{ optional($productTypes->find($selectedProductType))->name }}</h2>
    </div>

    <ul class="p-4 space-y-2">
        @foreach ($categories as $category)
            <li>
                <a href="#" class="block px-2 py-1 rounded hover:bg-gray-200"
                   @click.stop> <!-- 🔥 Evita que el clic cierre el menú -->
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
</div>
