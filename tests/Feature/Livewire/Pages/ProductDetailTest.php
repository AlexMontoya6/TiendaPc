<?php

use App\Livewire\Pages\ProductDetail;
use Livewire\Livewire;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);

it('carga el producto correctamente', function () {
    $product = $this->newProduct();

    Livewire::test(ProductDetail::class, ['product' => $product])
        ->assertSet('product', $product)
        ->assertSee($product->name)
        ->assertSee(strval($product->formatted_price)); // 🔥 Usamos `formatted_price`
});

it('carga las imágenes del producto', function () {
    $product = $this->newProduct();

    // Asegurarnos de que el producto tiene imágenes
    expect($product->images)->not()->toBeEmpty();

    Livewire::test(ProductDetail::class, ['product' => $product])
        ->assertSet('images', $product->images)
        ->assertSee($product->images->first()->path); // Verificamos que muestra una imagen
});

it('renderiza la vista correcta', function () {
    $product = $this->newProduct();

    Livewire::test(ProductDetail::class, ['product' => $product])
        ->assertViewIs('livewire.pages.product-detail');
});
