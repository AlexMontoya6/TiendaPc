<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class ProductCreate extends Component
{

    use WithFileUploads;

    public $name;
    public $slug;
    public $description;
    public $price;
    public $images = [];
    public $product_type_id;
    public $category_id;
    public $subcategory_id;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'images.*' => 'image|max:2048', // Cada imagen debe ser válida y de máximo 2MB
        ]);


        // Generar el slug automáticamente
        $slug = Str::slug($this->name);

        // Crear el producto
        $product = Product::create([
            'name' => $this->name,
            'slug' => $slug,
            'description' => $this->description,
            'price' => $this->price * 100, // Guardar en centavos
        ]);

        // Guardar imágenes en storage y en la base de datos
        foreach ($this->images as $image) {
            $path = $image->store('products', 'public'); // Guardar en storage/app/public/products
            $product->images()->create(['path' => $path]);
        }

        session()->flash('success', 'Producto creado correctamente.');
        return redirect()->route('admin.products.index');
    }

    public function updatedImages()
    {
        // Este método se ejecutará cuando el usuario seleccione imágenes
        $this->validate([
            'images.*' => 'image|max:2048',
        ]);
    }


    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }


    public function render()
    {
        return view('livewire.pages.admin.product-create')->layout('layouts.app');
    }
}
