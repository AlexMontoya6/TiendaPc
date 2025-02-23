<?php

namespace App\Livewire\Pages\Checkout;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ResumenPago extends Component
{
    public $shipping_name;

    public $shipping_street;

    public $shipping_city;

    public $shipping_postal_code;

    public $shipping_country;

    public $delivery_method;

    public $cartItems = [];

    public $cartTotal = 0;

    public $payment_method = 'card'; // Método de pago seleccionado

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

        // Obtener los productos del carrito desde la sesión
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
        $this->cartTotal = collect($this->cartItems)->sum(fn ($item) => $item['price'] * $item['qty']);
    }

    public function confirmOrder()
    {
        if ($this->payment_method === 'paypal') {
            // No hacemos nada aquí porque el formulario ya manejará PayPal
            session()->flash('message', 'Redirigiendo a PayPal...');
        } elseif ($this->payment_method === 'card') {
            session()->flash('message', 'Pago con tarjeta en proceso...');
            // Aquí podrías agregar la lógica para procesar pagos con tarjeta
        } elseif ($this->payment_method === 'bank_transfer') {
            session()->flash('message', 'Pago por transferencia bancaria seleccionado. Te enviaremos los detalles.');
            // Aquí podrías agregar lógica para manejar pagos por transferencia
        } else {
            session()->flash('error', 'Por favor, selecciona un método de pago.');
        }
    }

    public function render()
    {
        return view('livewire.pages.checkout.resumen-pago', [
            'cartTotal' => $this->cartTotal, // Pasamos el total a la vista
        ])->layout('layouts.checkout');
    }
}
