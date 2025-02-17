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
                    'price' => (float) preg_replace('/[^0-9.]/', '', $item->price) * 100,
                ];
            }),
            'cartTotal' => (float) preg_replace('/[^0-9.]/', '', ShoppingCart::subtotal()) * 100,

        ]);
    }
}
