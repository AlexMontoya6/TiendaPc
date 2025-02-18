<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductDetail extends Component
{
    public $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart()
    {
        $product = $this->product ?? Product::where('slug', request()->slug)->firstOrFail();

        Cart::add(
            $product->id,
            $product->name,
            1,
            $product->price
        );

        // ✅ Verifica que emit se usa dentro de un componente Livewire
        $this->dispatch('cartUpdated');

        session()->flash('success', 'Producto añadido al carrito.');
    }

    public function render()
    {
        return view('livewire.pages.product-detail')->layout('layouts.guest');
    }
}
