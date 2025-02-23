<?php

use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Support\Str;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);

it('puede crear un producto con todas sus relaciones', function () {
    $product = $this->newProduct(); // 🔥 Usa el Trait para crear el producto con imagen y relaciones

    expect($product)->toBeInstanceOf(Product::class)
        ->and($product->name)->not->toBeNull()
        ->and($product->productType)->not->toBeNull()
        ->and($product->category)->not->toBeNull()
        ->and($product->subcategory)->not->toBeNull()
        ->and($product->images)->not->toBeEmpty();
});

it('genera automáticamente un slug', function () {
    $product = $this->newProduct();

    expect($product->slug)->toBe(Str::slug($product->name));
});

it('puede acceder a su tipo, categoría y subcategoría', function () {
    $product = $this->newProduct();

    expect($product->productType)->not->toBeNull()
        ->and($product->category)->not->toBeNull()
        ->and($product->subcategory)->not->toBeNull();
});

it('puede tener imágenes asociadas', function () {
    $product = $this->newProduct();

    expect($product->images)->toHaveCount(1);
});

it('puede tener pagos asociados', function () {
    $product = $this->newProduct();
    $payment = Payment::factory()->create(['product_id' => $product->id]);

    expect($product->payments)->toHaveCount(1)
        ->and($product->payments->first()->id)->toBe($payment->id);

});

it('puede tener tags asociados', function () {
    $product = $this->newProduct(); // 🔥 Usa el trait para crear un producto con imagen y relaciones
    $tag = Tag::factory()->create(); // ✅ Crea un tag

    // Usa la nueva fábrica para crear la relación en `product_tag`
    ProductTag::factory()->create([
        'product_id' => $product->id,
        'tag_id' => $tag->id,
    ]);

    expect($product->tags)->toHaveCount(1)
        ->and($product->tags->first()->id)->toBe($tag->id);
});

it('formatea correctamente el precio', function () {
    $product = $this->newProduct();
    $product->update(['price' => 15000]); // 150€

    expect($product->formatted_price)->toBe(150.00);
});

it('devuelve null si el precio es menor a 100 céntimos', function () {
    $product = $this->newProduct();
    $product->update(['price' => 50]); // 🔥 50 céntimos

    expect($product->formatted_price)->toBeNull();
});
