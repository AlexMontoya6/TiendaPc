<?php

use App\Models\Category;
use App\Models\ProductType;
use App\Models\Subcategory;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);

use function Pest\Laravel\getJson;



it('devuelve una lista de categorías en JSON', function () {
    ProductType::factory()->create();
    Category::factory()->count(3)->create();

    $response = getJson(route('api.categories.index'));

    $response->assertOk()
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [['name', 'description']]
        ]);
});




