<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Product;
use App\Traits\HandlesCart;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductDetail extends Component
{

    use HandlesCart;

    public $product;
    public $images; // Guardaremos aquí las imágenes

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->images = $product->images; // Cargar todas las imágenes relacionadas
    }


    public function render()
    {
        return view('livewire.pages.product-detail', [
            'images' => $this->images // Pasamos las imágenes a la vista
        ])->layout('layouts.guest');
    }
}
