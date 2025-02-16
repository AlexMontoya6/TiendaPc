<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart as ShoppingCart;

class Cart extends Component
{
    protected $listeners = ['cartUpdated', 'addToCart' => 'handleAddToCart'];

    public function handleAddToCart($productId)
    {
        $product = Product::findOrFail($productId);

        ShoppingCart::add(
            $product->id,
            $product->name,
            1,
            $product->price / 100
        );

        $this->dispatch('cartUpdated');
    }


    public function render()
    {
        return view('livewire.cart', [
            'cartItems' => ShoppingCart::content()->map(function ($item) {
                return [
                    'id' => $item->rowId,
                    'name' => $item->name,
                    'qty' => (int) $item->qty,
                    'price' => (float) $item->price,
                    'subtotal' => (float) $item->price * (int) $item->qty,
                ];
            }),
            'cartCount' => (int) ShoppingCart::count(),
            'cartTotal' => (float) ShoppingCart::total(),
        ]);
    }
}
