<?php

use App\Models\ProductType;
use App\Models\Category;

it('puede crear un tipo de producto', function () {
    $productType = ProductType::factory()->create([
        'name' => 'Electrónica',
    ]);

    expect($productType)->toBeInstanceOf(ProductType::class)
        ->and($productType->name)->toBe('Electrónica');
});

it('puede tener categorías asociadas', function () {
    $productType = ProductType::factory()->create();
    $category = Category::factory()->create(['product_type_id' => $productType->id]);

    expect($productType->categories)->toHaveCount(1)
        ->and($productType->categories->first()->id)->toBe($category->id);
});
