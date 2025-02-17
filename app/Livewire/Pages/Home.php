<?php

namespace App\Livewire\Pages;

use App\Models\Product;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class Home extends Component
{


    public function addToCart($productId)
    {
        $product = \App\Models\Product::findOrFail($productId);

        Cart::add(
            $product->id, // ID del producto
            $product->name, // Nombre del producto
            1, // Cantidad
            $product->price // Precio
        );

        $this->emit('cartUpdated'); // Emitimos un evento para actualizar la vista del carrito
    }

    public function render()
    {
        $products = Product::with(['images' => function ($query) {
            $query->where('order', 1)->orderBy('order');
        }])->paginate(8);

        return view('livewire.pages.home', compact('products'))
            ->layout('layouts.guest');
    }
}
