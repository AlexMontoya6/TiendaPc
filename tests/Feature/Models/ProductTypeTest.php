<?php

use App\Models\Category;
use App\Models\ProductType;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);

beforeEach(function () {
    // 🔹 Creamos un ProductType antes de cada test
    $this->productType = ProductType::factory()->create();
});

it('puede crear un tipo de producto', function () {
    $productType = ProductType::factory()->create([
        'name' => 'Electrónica',
    ]);

    expect($productType)->toBeInstanceOf(ProductType::class)
        ->and($productType->name)->toBe('Electrónica');
});

it('puede tener categorías asociadas', function () {
    $category = Category::factory()->create(['product_type_id' => $this->productType->id]);

    expect($this->productType->categories)->toHaveCount(1)
        ->and($this->productType->categories->first()->id)->toBe($category->id);
});

it('puede tener productos asociados', function () {
    $product = $this->newProduct();

    $product->update(['product_type_id' => $this->productType->id]);

    $this->productType->refresh();

    expect($this->productType->products)->toHaveCount(1)
        ->and($this->productType->products->first()->id)->toBe($product->id);
});
