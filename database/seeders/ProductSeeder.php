<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Image;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Obtener los tres primeros tipos de productos
        $productTypes = ProductType::limit(3)->get(); // Limitamos a los tres primeros tipos

        foreach ($productTypes as $productType) {
            // Obtener las categorías asociadas a este tipo de producto
            $categories = Category::where('product_type_id', $productType->id)->get();

            foreach ($categories as $category) {
                // Crear productos para cada categoría asociada al tipo de producto
                $product = Product::factory()->create([
                    'product_type_id' => $productType->id,
                    'category_id' => $category->id,
                ]);

                // Generar entre 1 y 3 imágenes para el producto
                $imagesCount = rand(1, 3); // Generamos entre 1 y 3 imágenes

                for ($i = 0; $i < $imagesCount; $i++) {
                    Image::factory()->create([
                        'product_id' => $product->id,
                    ]);
                }
            }
        }
    }
}
