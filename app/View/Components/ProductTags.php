<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product;

class ProductTags extends Component
{
    public $tags;

    public function __construct(Product $product)
    {
        // 🔹 Filtrar solo etiquetas activas
        $this->tags = $product->tags->where('pivot.is_active', true);
    }

    public function render()
    {
        return view('components.product-tags');
    }
}
