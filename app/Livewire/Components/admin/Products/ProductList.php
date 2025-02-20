<?php

namespace App\Livewire\Components\admin\Products;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class ProductList extends Component
{
    use WithPagination;

    public $search = ''; // Variable para el buscador
    public $perPage = 8; // Cantidad de productos por página

    protected $queryString = ['search']; // Guarda el valor en la URL

    public function updateSearch($value)
    {
        $this->search = $value;
        $this->resetPage(); // Reiniciar la paginación cuando se busca algo
    }

    public function render()
    {
        // 🔹 Hacemos la consulta en tiempo real
        $query = Product::with('images');

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $products = $query->orderBy('id', 'desc')->paginate($this->perPage);

        return view('livewire.product-list', compact('products'));
    }
}
