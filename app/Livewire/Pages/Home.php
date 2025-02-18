<?php

namespace App\Livewire\Pages;

use App\Models\Product;
use App\Traits\HandlesCart;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class Home extends Component
{
    use HandlesCart;

    public function render()
    {
        $products = Product::with(['images' => function ($query) {
            $query->where('order', 1)->orderBy('order');
        }])->paginate(8);

        return view('livewire.pages.home', compact('products'))
            ->layout('layouts.guest');
    }
}
