<?php

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);

it('puede crear una imagen y asignarla a un producto', function () {
    $product = $this->newProduct();

    $image = Image::factory()->create([
        'product_id' => $product->id,
        'path' => 'products/test-image.jpg',
        'order' => 2,
    ]);

    expect($image)->toBeInstanceOf(Image::class)
        ->and($image->product)->toBeInstanceOf(Product::class)
        ->and($image->product->id)->toBe($product->id);
});

it('puede recuperar la imagen correctamente', function () {
    Storage::fake('public');

    $product = $this->newProduct();
    $image = Image::factory()->create([
        'product_id' => $product->id,
        'path' => 'products/test-image.jpg',
        'order' => 2,
    ]);

    Storage::disk('public')->put($image->path, 'contenido de prueba');

    expect(Storage::disk('public')->exists($image->path))->toBeTrue();
});

it('puede acceder a su producto relacionado', function () {
    $product = $this->newProduct();
    $image = Image::factory()->create(['product_id' => $product->id, 'order' => 2]);

    expect($image->product)->toBeInstanceOf(Product::class);
});
