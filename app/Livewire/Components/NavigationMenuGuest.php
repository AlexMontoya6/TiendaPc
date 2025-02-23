<?php

namespace App\Livewire\Components;

use App\Models\ProductType;
use Livewire\Component;

class NavigationMenuGuest extends Component
{
    public $isOpen = false; // Estado del menú principal
    public $selectedProductType = null; // Tipo de producto seleccionado
    public $categories = []; // Categorías cargadas

    // Abre el menú principal
    public function openMenu()
    {
        $this->isOpen = true;
        $this->selectedProductType = null;
        $this->categories = [];
    }

    // Cierra todo el menú
    public function closeMenu()
    {
        $this->isOpen = false;
        $this->selectedProductType = null;
        $this->categories = [];
    }

    // Cargar las categorías cuando se selecciona un tipo de producto
    public function selectProductType($productTypeId)
    {
        $this->selectedProductType = $productTypeId;
        $this->categories = ProductType::find($productTypeId)?->categories ?? [];
    }

    public function render()
    {
        return view('livewire.components.navigation-menu-guest', [
            'productTypes' => ProductType::all(),
        ]);
    }
}
