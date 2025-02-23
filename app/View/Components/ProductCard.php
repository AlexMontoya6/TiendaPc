<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCard extends Component
{
    public $product;

    /**
     * Create a new component instance.
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|string
    {
        return view('components.product-card', [
            'product' => $this->product,
        ]);
    }
}
