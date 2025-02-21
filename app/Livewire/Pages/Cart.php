<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart as Shoppingcart;
use App\Models\Product;
use Illuminate\Support\Facades\Log;


class Cart extends Component
{
    public $cartItems = [];
    public $cartTotal = 0;
    public $quantities = [];

    protected $listeners = [
        'addToCart' => 'addProductToCart', // 🔹 Escuchar evento para agregar productos
        'clearCart' => 'clearCartHandler', // 🔹 Escuchar evento para vaciar el carrito
    ];

    public function mount()
    {
        $this->loadCart(); // 🔹 Carga inicial del carrito
    }

    public function loadCart()
    {
        $this->cartItems = collect(Shoppingcart::content()->map(function ($item) {
            return (object) [
                'rowId' => $item->rowId,
                'id' => $item->id,
                'name' => $item->name,
                'qty' => (int) $item->qty,
                'price' => (float) preg_replace('/[^0-9.]/', '', $item->price),
            ];
        })->toArray());

        foreach ($this->cartItems as $item) {
            $this->quantities[$item->rowId] = $item->qty > 0 ? $item->qty : 1;
        }

        $this->cartTotal = (float) preg_replace('/[^0-9.]/', '', Shoppingcart::subtotal());
    }

    public function addProductToCart($data)
    {
        $product = Product::find($data['productId']);

        if (!$product) {
            return;
        }

        Shoppingcart::add($product->id, $product->name, 1, $product->price);
        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    public function updateQuantity($rowId, $newQty = 1)
    {
        $newQty = (int) $newQty;

        if ($newQty < 1) {
            $newQty = 1;
        }

        if (Shoppingcart::get($rowId)) {
            Shoppingcart::update($rowId, $newQty);
            $this->loadCart();
        }
    }

    public function removeFromCart($rowId)
    {
        Shoppingcart::remove($rowId);
        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    public function clearCartHandler()
    {
        Log::info("✅ Evento clearCart recibido en Cart.php");

        // Obtener todos los productos del carrito
        $cartItems = Shoppingcart::content();
        Log::info("Carrito antes de vaciarse:", ['items' => $cartItems]);

        // Eliminar cada ítem manualmente
        foreach ($cartItems as $item) {
            Shoppingcart::remove($item->rowId);
        }

        Log::info("✅ Carrito vaciado correctamente.");

        // Recargar el carrito
        $this->loadCart();
        $this->dispatch('cartUpdated'); // Notificar que el carrito ha sido vaciado
    }


    public function render()
    {
        return view('livewire.pages.cart')->layout('layouts.checkout');
    }
}
