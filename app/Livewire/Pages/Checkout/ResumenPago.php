<?php

namespace App\Livewire\Pages\Checkout;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class ResumenPago extends Component
{
    public $shipping_name, $shipping_street, $shipping_city, $shipping_postal_code, $shipping_country;
    public $delivery_method;
    public $cartItems = [];
    public $cartTotal = 0;
    public $payment_method = 'card';
    public $editingAddress = false;
    public $editingDelivery = false;
    public $editingCart = false;


    public function mount()
    {
        // Cargar los datos desde la sesión
        $this->shipping_name = Session::get('shipping_name');
        $this->shipping_street = Session::get('shipping_street');
        $this->shipping_city = Session::get('shipping_city');
        $this->shipping_postal_code = Session::get('shipping_postal_code');
        $this->shipping_country = Session::get('shipping_country');
        $this->delivery_method = Session::get('delivery_method', 'standard');

        // Obtener los productos del carrito desde la sesión (Gloudemans\Shoppingcart)
        $cart = Cart::instance('default')->content();

        // Convertir los objetos CartItem a arrays
        $this->cartItems = $cart->map(function ($item) {
            return [
                'rowId' => $item->rowId,
                'id' => $item->id,
                'name' => $item->name,
                'qty' => $item->qty,
                'price' => $item->price,
            ];
        })->toArray();

        // Calcular total
        $this->cartTotal = collect($this->cartItems)->sum(fn($item) => $item['price'] * $item['qty']);
    }



    public function confirmOrder()
    {
        // Aquí podríamos procesar el pedido y redirigir al pago
        session()->flash('message', 'Pedido confirmado. Redirigiendo al pago...');
    }

    public function render()
    {
        return view('livewire.pages.checkout.resumen-pago')
            ->layout('layouts.checkout');
    }
}
