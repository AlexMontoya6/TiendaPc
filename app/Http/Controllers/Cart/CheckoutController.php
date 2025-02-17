<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Livewire\Cart;
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


    public function delivery()
    {
        return view('pages.cart.checkout.entrega');
    }

    public function storeDelivery(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|string|in:standard,express',
        ]);

        // Guardamos la opción de entrega en sesión
        session(['delivery_method' => $request->delivery_method]);

        return redirect()->route('cart.checkout.resumen_pago');
    }


    public function resumenPago()
    {
        $cartItems = \Gloudemans\Shoppingcart\Facades\Cart::content()->map(function ($item) {
            return [
                'id' => $item->rowId,
                'name' => $item->name,
                'qty' => (int) $item->qty,
                'price' => (float) $item->price,
                'subtotal' => (float) $item->subtotal,
            ];
        });

        $cartTotal = \Gloudemans\Shoppingcart\Facades\Cart::subtotal() * 100;

        return view('pages.cart.checkout.resumen_pago', [
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
        ]);
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:card,paypal,bank_transfer',
        ]);

        // Guardamos el método de pago en sesión
        session(['payment_method' => $request->payment_method]);

        return redirect()->route('cart.checkout.revision');
    }



    public function process() {}    // Procesar pago y confirmar pedido
}
