<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $productTypes = ProductType::all();

        foreach ($productTypes as $productType) {
            $categories = Category::where('product_type_id', $productType->id)->get();

            foreach ($categories as $category) {
                // Si la categoría es "Portátiles", creamos 8 productos en vez de 1
                $productsToCreate = ($category->name === 'Portátiles') ? 8 : 1;

                for ($p = 0; $p < $productsToCreate; $p++) {
                    $product = Product::factory()->create([
                        'product_type_id' => $productType->id,
                        'category_id' => $category->id,
                    ]);

                    $imagesCount = rand(1, 3);

                    for ($i = 0; $i < $imagesCount; $i++) {
                        Image::factory()->create([
                            'product_id' => $product->id,
                            'order' => $i + 1,
                        ]);
                    }
                }
            }
        }
    }
}
