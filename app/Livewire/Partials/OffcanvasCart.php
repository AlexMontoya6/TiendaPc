<?php

namespace App\Livewire\Partials;

use App\Models\Product;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart as ShoppingCart;
use Illuminate\Support\Facades\Auth;

class OffcanvasCart extends Component
{
    protected $listeners = ['cartUpdated', 'addToCart' => 'handleAddToCart'];

    public function mount()
    {
        if (Auth::check()) {
            $this->loadCartFromDatabase(); // Cargar carrito si el usuario está autenticado
        }
    }

    public function handleAddToCart($productId)
    {
        $product = Product::findOrFail($productId);

        ShoppingCart::add(
            $product->id,
            $product->name,
            1,
            $product->price /100
        );

        $this->saveCartToDatabase(); // Guardar carrito en la base de datos
        $this->dispatch('cartUpdated');
    }

    public function removeFromCart($rowId)
    {
        ShoppingCart::remove($rowId); // Eliminamos el producto del carrito
        $this->saveCartToDatabase(); // Guardamos el carrito actualizado en la BD
        $this->dispatch('cartUpdated'); // Emitimos el evento para actualizar la vista
    }

    public function loadCartFromDatabase()
    {
        $userId = Auth::id(); // Obtiene el ID del usuario autenticado
        ShoppingCart::restore($userId); // Restaura el carrito desde la BD
        $this->dispatch('cartUpdated'); // Actualiza la vista
    }

    public function saveCartToDatabase()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            ShoppingCart::erase($userId);
            ShoppingCart::store($userId);
        }
    }

    public function render()
    {
        return view('livewire.partials.offcanvas-cart', [
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
