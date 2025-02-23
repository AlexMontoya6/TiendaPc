<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

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
