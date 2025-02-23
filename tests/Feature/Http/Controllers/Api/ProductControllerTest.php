<?php

use function Pest\Laravel\getJson;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);


it('devuelve una lista de productos en JSON', function () {
    for ($i = 0; $i < 5; $i++) {
        $this->newProduct();
    }

    $response = getJson(route('api.products.index'));

    $response->assertOk()
        ->assertJsonCount(5) // 🔥 Confirma que hay 5 productos en el array
        ->assertJsonStructure([
            '*' => [ // 🔥 El `*` indica que cada producto en la lista tiene esta estructura
                'name',
                'slug',
                'description',
                'price',
            ]
        ]);
});


