<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productTypes = [
            [
                'name' => 'Componentes',
                'description' => 'Componentes de ordenadores',
            ],
            [
                'name' => 'Ordenadores',
                'description' => 'Ordenadores de todo tipo',
            ],
            [
                'name' => 'Periféricos',
                'description' => 'Periféricos de ordenadores',
            ],
            [
                'name' => 'Gaming y videojuegos',
                'description' => 'Gaming y videojuegos para los mas pequeños y los no tan pequeños',
            ],
            [
                'name' => 'Smartphones y tablets',
                'description' => 'Smartphones de todas las marcas y modelos',
            ],
            [
                'name' => 'Televisores',
                'description' => 'Televisores de todas las marcas y modelos',
            ],
            [
                'name' => 'Sonido',
                'description' => 'Sonido de todas las marcas y modelos',
            ],
            [
                'name' => 'Reloges inteligentes ',
                'description' => 'Reloges inteligentes de todas las marcas y modelos',
            ],
            [
                'name' => 'Electrodomésticos',
                'description' => 'Electrodomésticos de todas las marcas y modelos',
            ],
            [
                'name' => 'Hogar',
                'description' => 'Hogar de todas las marcas y modelos',
            ],
            [
                'name' => 'Fotografía',
                'description' => 'Fotografía de todas las marcas y modelos',
            ],
            [
                'name' => 'Ocio y movilidad',
                'description' => 'Ocio y movilidad de todas las marcas y modelos',
            ],

        ];

        foreach ($productTypes as $productType) {
            ProductType::create([
                'name' => $productType['name'],
                'slug' => Str::slug($productType['name']),
                'description' => $productType['description'],
            ]);
        }
    }
}
