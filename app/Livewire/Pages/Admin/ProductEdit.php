<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Validation\Rule;

class ProductEdit extends Component
{
    public $product; // Para manejar producto en edición
    public $name;
    public $slug;
    public $description;
    public $price;
    public $product_type_id;
    public $category_id;
    public $subcategory_id;

    public function mount(Product $product = null)
    {
        if ($product) {
            $this->product = $product;
            $this->name = $product->name;
            $this->slug = $product->slug;
            $this->description = $product->description;
            $this->price = $product->price / 100;
            $this->product_type_id = $product->product_type_id;
            $this->category_id = $product->category_id;
            $this->subcategory_id = $product->subcategory_id;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('products')->ignore(optional($this->product)->id)],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'product_type_id' => 'required|exists:product_types,id',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ]);

        if ($this->product) {
            // Editar producto existente
            $this->product->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'price' => $this->price * 100, // Guardar en centavos
                'product_type_id' => $this->product_type_id,
                'category_id' => $this->category_id,
                'subcategory_id' => $this->subcategory_id,
            ]);
        } else {
            // Crear un nuevo producto
            Product::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'price' => $this->price * 100, // Guardar en centavos
                'product_type_id' => $this->product_type_id,
                'category_id' => $this->category_id,
                'subcategory_id' => $this->subcategory_id,
            ]);
        }

        session()->flash('success', 'Producto guardado correctamente.');
        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        return view('livewire.pages.admin.product-edit')
            ->layout('layouts.app');
    }
}
