<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class Products extends Component
{

    use WithPagination;

    public $search = ''; // Campo de búsqueda
    public $perPage = 8; // Número de productos por página


    public function updateSearch($value)
    {
        $this->search = $value;
        $this->resetPage(); // Reiniciar paginación al buscar
    }


    public function render()
{
    $query = Product::with('images');

    if (!empty($this->search)) {
        $query->where('name', 'like', '%' . $this->search . '%');
    }

    $products = $query->orderBy('id', 'desc')->paginate($this->perPage);

    return view('livewire.pages.admin.products', compact('products'))
        ->layout('layouts.app');
}

}
