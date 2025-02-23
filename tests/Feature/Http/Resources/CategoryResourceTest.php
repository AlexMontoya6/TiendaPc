<?php

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Http\Request;

it('devuelve la estructura correcta de CategoryResource', function () {
    ProductType::factory()->create();

    $category = Category::factory()->create();

    $resource = (new CategoryResource($category))->toArray(new Request);

    expect($resource)->toHaveKeys(['name', 'slug', 'description'])
        ->and($resource['name'])->toBe($category->name)
        ->and($resource['description'])->toBe($category->description);
});
