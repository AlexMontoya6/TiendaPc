<?php

use App\Models\Product;
use App\Models\Tag;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);


it('puede crear un tag correctamente', function () {
    $tag = Tag::factory()->create();

    expect($tag)->toBeInstanceOf(Tag::class)
        ->and($tag->name)->not->toBeNull()
        ->and($tag->description)->not->toBeNull();
});

it('puede asignarse a productos', function () {
    $product = $this->newProduct();
    $tag = Tag::factory()->create();

    $product->tags()->attach($tag->id, [
        'ttl' => now()->addDays(30),
        'is_active' => true
    ]);

    expect($product->tags)->toHaveCount(1)
        ->and($product->tags->first()->id)->toBe($tag->id);
});

it('devuelve solo los productos activos', function () {
    $tag = Tag::factory()->create();

    $activeProduct = $this->newProduct();
    $inactiveProduct = $this->newProduct();

    $tag->products()->attach($activeProduct->id, ['ttl' => now()->addDays(30), 'is_active' => true]);
    $tag->products()->attach($inactiveProduct->id, ['ttl' => now()->subDays(1), 'is_active' => false]);

    expect($tag->activeProducts)->toHaveCount(1)
        ->and($tag->activeProducts->first()->id)->toBe($activeProduct->id);
});
