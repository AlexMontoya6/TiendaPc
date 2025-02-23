<?php

use App\Http\Resources\ProductResource;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);

it('formatea correctamente un producto', function () {
    $product = $this->newProduct(); // 🔥 Creamos un producto con el Trait

    $resource = new ProductResource($product);
    $array = $resource->toArray(request());

    expect($array)->toMatchArray([
        'id' => $product->id,
        'name' => $product->name,
        'price' => number_format($product->price, 2),
        'description' => $product->description,
        'available' => $product->stock > 0,
        'category' => $product->category->name ?? null,
        'created_at' => $product->created_at->toIso8601String(),
    ]);
});
