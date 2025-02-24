<?php

use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);

it('renderiza correctamente la tarjeta del producto', function () {
    $product = $this->newProduct();

    $component = View::make('components.product-card', ['product' => $product])->render();

    expect($component)
        ->toContain($product->name)
        ->toContain($product->getFormattedPriceAttribute() . ' €')
        ->toContain(Str::limit($product->description, 50));

    expect($component)->toContain(route('product.detail', $product->slug));

    expect($component)->toContain("wire:click=\"\$dispatch('addToCart', { productId: {$product->id} })\"");
});

it('muestra correctamente la primera imagen del producto', function () {
    $product = $this->newProduct();

    $component = View::make('components.product-card', ['product' => $product])->render();

    expect($component)->toContain(asset('storage/' . $product->images->first()->path));
});
