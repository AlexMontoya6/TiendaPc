<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            'Componentes' => [
                'Componentes de ordenadores',
                'Placas base',
                'Memorias RAM',
                'Discos duros',
            ],
            'Ordenadores' => [
                'Portátiles',
                'Sobremesa',
                'All-in-One',
                'Estaciones de trabajo',
            ],
            'Periféricos' => [
                'Teclados',
                'Ratones',
                'Monitores',
                'Impresoras',
            ],
            'Gaming y videojuegos' => [
                'Consolas de videojuegos',
                'Accesorios de gaming',
                'Juegos',
            ],
            'Smartphones y tablets' => [
                'Smartphones Android',
                'iPhones',
                'Tablets',
            ],
            'Televisores' => [
                'Televisores 4K',
                'Smart TVs',
                'OLED',
            ],
            'Sonido' => [
                'Altavoces',
                'Auriculares',
                'Barra de sonido',
            ],
            'Relojes inteligentes' => [
                'Relojes deportivos',
                'Relojes fitness',
                'Smartwatches',
            ],
            'Electrodomésticos' => [
                'Lavadoras',
                'Frigoríficos',
                'Microondas',
            ],
            'Hogar' => [
                'Mobiliario',
                'Decoración',
                'Iluminación',
            ],
            'Fotografía' => [
                'Cámaras DSLR',
                'Lentes',
                'Accesorios fotográficos',
            ],
            'Ocio y movilidad' => [
                'Bicicletas',
                'Patinetes eléctricos',
                'Juguetes',
            ],
        ];

        foreach ($categories as $productTypeName => $categoryNames) {

            $productType = ProductType::where('name', $productTypeName)->first();

            if (!$productType) {
                continue;
            }

            foreach ($categoryNames as $categoryName) {
                Category::create([
                    'name' => $categoryName,
                    'slug' => Str::slug($categoryName),
                    'description' => "Descripción de $categoryName",
                    'product_type_id' => $productType->id,
                ]);
            }
        }
    }
}
