<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // Selección de dirección de envío
    public function shipping()
    {
        $user = auth()->user();
        $addresses = $user->addresses; // Suponiendo que el usuario tiene varias direcciones

        return view('pages.cart.checkout.envio', compact('addresses'));
    }
    public function delivery() {}   // Método de entrega
    public function payment() {}    // Método de pago
    public function review() {}     // Resumen y confirmación
    public function process() {}    // Procesar pago y confirmar pedido
}
