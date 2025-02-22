<?php

use App\Models\Category;
use App\Models\ProductType;
use App\Models\Subcategory;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);

beforeEach(function () {
    $this->productType = ProductType::factory()->create();

    $this->category = Category::factory()->create([
        'product_type_id' => $this->productType->id,
    ]);
});


it('puede crear una categoría', function () {
    $category = Category::factory()->create([
        'product_type_id' => $this->productType->id, // ✅ Usa el ProductType ya creado
    ]);

    expect($category)->toBeInstanceOf(Category::class)
        ->and($category->product_type_id)->toBe($this->productType->id);
});


it('puede pertenecer a un ProductType', function () {
    expect($this->category->productType)->toBeInstanceOf(ProductType::class)
        ->and($this->category->productType->id)->toBe($this->productType->id);
});


it('puede tener subcategorías asociadas', function () {
    $subcategory = Subcategory::factory()->create([
        'category_id' => $this->category->id, // ✅ Relacionamos con la categoría creada en beforeEach
    ]);

    // 🔍 Recargamos la categoría para evitar caché en la consulta
    $this->category->refresh();

    expect($this->category->subcategories)->toHaveCount(1)
        ->and($this->category->subcategories->first()->id)->toBe($subcategory->id);
});

it('puede tener productos asociados', function () {
    $product = $this->newProduct();

    $product->update(['category_id' => $this->category->id]);

    $this->category->refresh();

    expect($this->category->products)->toHaveCount(1)
        ->and($this->category->products->first()->id)->toBe($product->id);
});

