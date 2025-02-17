<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Gloudemans\Shoppingcart\Facades\Cart as ShoppingCart;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index()
    {
        return view('pages.cart.cart', [
            'cartItems' => ShoppingCart::content()->map(function ($item) {
                return [
                    'id' => $item->rowId,
                    'name' => $item->name,
                    'qty' => (int) $item->qty,
                    'price' => (float) $item->price * 100, // Convertimos a centavos
                ];
            }),
            'cartTotal' => ShoppingCart::total() * 100, // Convertimos el total a centavos
        ]);
    }
}
