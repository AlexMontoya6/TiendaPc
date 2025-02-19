<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use App\Models\Product;

class Products extends Component
{

    public $search = ''; // Campo de búsqueda
    public $perPage = 10; // Número de productos por página

    public function updatingSearch()
    {
        $this->resetPage(); // Reiniciar la paginación al buscar
    }

    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('livewire.pages.admin.products', compact('products'))
            ->layout('layouts.app');
    }
}
