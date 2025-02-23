<?php

namespace App\Livewire\Components\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $search = ''; // Variable para el buscador

    public $perPage = 8; // Cantidad de productos por página

    public $confirmingProductDeletion = false;

    public $productToDelete;

    protected $queryString = ['search']; // Guarda el valor en la URL

    protected $listeners = ['deleteProduct' => 'confirmDelete'];

    public function updateSearch($value)
    {
        $this->search = $value;
        $this->resetPage(); // Reiniciar la paginación cuando se busca algo
    }

    public function confirmDelete($productId)
    {
        $this->productToDelete = $productId;
        $this->confirmingProductDeletion = true;
    }

    public function delete()
    {
        $product = Product::find($this->productToDelete);

        if ($product) {
            $product->delete();
            session()->flash('success', 'Producto eliminado correctamente.');
        } else {
            session()->flash('error', 'No se encontró el producto.');
        }

        $this->confirmingProductDeletion = false;
        $this->productToDelete = null;
    }

    public function render()
    {
        $query = Product::with('images');

        if (! empty($this->search)) {
            $query->where('name', 'like', '%'.$this->search.'%');
        }

        $products = $query->orderBy('id', 'desc')->paginate($this->perPage);

        return view('livewire.product-list', compact('products'));
    }
}
