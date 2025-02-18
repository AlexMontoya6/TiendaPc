<?php

namespace App\Traits;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

trait HandlesCart
{
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        Cart::add(
            $product->id,  // ID del producto
            $product->name, // Nombre del producto
            1,              // Cantidad
            $product->price // Precio
        );

        session()->flash('success', 'Producto añadido al carrito.');

        $this->emit('cartUpdated'); // Para actualizar la vista del carrito
    }
}
