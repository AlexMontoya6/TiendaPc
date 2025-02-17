<?php

namespace App\Livewire\Pages\Checkout;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Entrega extends Component
{
    public $delivery_method = 'standard';

    public function mount()
    {
        // Cargar la opción guardada en sesión si existe
        $this->delivery_method = Session::get('delivery_method', 'standard');
    }

    public function setDeliveryMethod($method)
    {
        $this->delivery_method = $method;
    }

    public function save()
    {
        // Guardar la opción en sesión
        Session::put('delivery_method', $this->delivery_method);

        // Redirigir al resumen de pago
        return redirect()->route('cart.checkout.resumen_pago');
    }

    public function render()
    {
        return view('livewire.pages.checkout.entrega')->layout('layouts.checkout');
    }
}
