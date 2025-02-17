<?php

namespace App\Livewire\Pages\Checkout;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class ResumenPago extends Component
{
    public $shipping_name, $shipping_street, $shipping_city, $shipping_postal_code, $shipping_country;
    public $delivery_method;
    public $cartItems = [];
    public $cartTotal = 0;
    public $payment_method = 'card';

    public function mount()
    {
        // Cargar los datos desde la sesión
        $this->shipping_name = Session::get('shipping_name');
        $this->shipping_street = Session::get('shipping_street');
        $this->shipping_city = Session::get('shipping_city');
        $this->shipping_postal_code = Session::get('shipping_postal_code');
        $this->shipping_country = Session::get('shipping_country');
        $this->delivery_method = Session::get('delivery_method', 'standard');

        // Simular datos del carrito (se debería conectar con un carrito real)
        $this->cartItems = [
            ['name' => 'Producto 1', 'qty' => 2, 'price' => 20.00],
            ['name' => 'Producto 2', 'qty' => 1, 'price' => 50.00],
        ];

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
