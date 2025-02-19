<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class ProductList extends Component
{
    public $products; // Productos pasados desde Blade
    public $search = ''; // Variable para el buscador

    protected $queryString = ['search']; // Guarda la búsqueda en la URL

    public function updatingSearch()
    {
        $this->resetPage(); // Reinicia la búsqueda
    }

    public function getFilteredProductsProperty()
    {
        return collect($this->products)
            ->filter(fn($product) => str_contains(strtolower($product->name), strtolower($this->search)))
            ->sortByDesc('id')
            ->values();
    }

    public function render()
    {
        return view('livewire.product-list', [
            'products' => $this->filteredProducts, // 🔹 Pasamos la lista completa sin paginar
        ]);
    }
}
