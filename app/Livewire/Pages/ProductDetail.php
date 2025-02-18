<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductDetail extends Component
{
    public $product;
    public $images; // Guardaremos aquí las imágenes

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->images = $product->images; // Cargar todas las imágenes relacionadas
    }

    public function addToCart($productId)
    {
        $product = \App\Models\Product::findOrFail($productId);

        Cart::add(
            $product->id, // ID del producto
            $product->name, // Nombre del producto
            1, // Cantidad
            $product->price // Precio
        );

        session()->flash('success', 'Producto añadido al carrito.');

        $this->emit('cartUpdated'); // Emitimos un evento para actualizar la vista del carrito
    }

    public function render()
    {
        return view('livewire.pages.product-detail', [
            'images' => $this->images // Pasamos las imágenes a la vista
        ])->layout('layouts.guest');
    }
}
