<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use App\Models\Product;

class ProductCreate extends Component
{
    public $name;
    public $slug;
    public $description;
    public $price;
    public $product_type_id;
    public $category_id;
    public $subcategory_id;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'product_type_id' => 'required|exists:product_types,id',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ]);

        Product::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price * 100,
            'product_type_id' => $this->product_type_id,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
        ]);

        session()->flash('success', 'Producto creado correctamente.');
        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        return view('livewire.pages.admin.product-create')->layout('layouts.app');
    }
}
