<?php

use App\Models\Product;
use App\Models\Tag;
use App\Models\ProductTag;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);

it('puede crear una relación product-tag correctamente', function () {
    $product = $this->newProduct();
    $tag = Tag::factory()->create();

    $productTag = ProductTag::create([
        'product_id' => $product->id,
        'tag_id' => $tag->id,
        'ttl' => now()->addDays(30),
        'is_active' => true,
    ]);

    expect($productTag)->toBeInstanceOf(ProductTag::class)
        ->and($productTag->product_id)->toBe($product->id)
        ->and($productTag->tag_id)->toBe($tag->id);
});

it('verifica que ttl e is_active se guardan correctamente', function () {
    $product = $this->newProduct();
    $tag = Tag::factory()->create();

    $productTag = ProductTag::factory()->create([
        'product_id' => $product->id,
        'tag_id' => $tag->id,
        'ttl' => now()->addDays(7),
        'is_active' => false,
    ]);

    expect($productTag->ttl)->not->toBeNull()
        ->and($productTag->is_active)->toBeFalse();
});


it('puede acceder a su producto y tag', function () {
    $product = $this->newProduct();
    $tag = Tag::factory()->create();

    $productTag = ProductTag::factory()->create([
        'product_id' => $product->id,
        'tag_id' => $tag->id,
    ]);

    expect($productTag->product)->toBeInstanceOf(Product::class)
        ->and($productTag->tag)->toBeInstanceOf(Tag::class);
});

it('evita la creación de duplicados en product_tag', function () {
    $product = $this->newProduct();
    $tag = Tag::factory()->create();

    ProductTag::create([
        'product_id' => $product->id,
        'tag_id' => $tag->id,
    ]);

    expect(fn () => ProductTag::create([
        'product_id' => $product->id,
        'tag_id' => $tag->id,
    ]))->toThrow(\Exception::class, "El producto ya tiene esta etiqueta asignada.");
});
