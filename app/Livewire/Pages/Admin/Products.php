<?php

namespace App\Livewire\Pages\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 8;

    protected $queryString = ['search']; // 🔹 Mantiene el valor de búsqueda en la URL

    public function updateSearch($value)
    {
        $this->search = $value;
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with('images');

        if (! empty($this->search)) {
            $query->where('name', 'like', '%'.$this->search.'%');
        }

        $products = $query->orderBy('id', 'desc')->paginate($this->perPage);

        return view('livewire.pages.admin.products', compact('products'))
            ->layout('layouts.app');
    }
}
