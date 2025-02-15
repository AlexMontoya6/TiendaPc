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
        $productTypes = ProductType::limit(3)->get();

        foreach ($productTypes as $productType) {
            $categories = Category::where('product_type_id', $productType->id)->get();

            foreach ($categories as $category) {
                $product = Product::factory()->create([
                    'product_type_id' => $productType->id,
                    'category_id' => $category->id,
                ]);

                $imagesCount = rand(1, 3);

                for ($i = 0; $i < $imagesCount; $i++) {
                    Image::factory()->create([
                        'product_id' => $product->id,
                        'order' => $i +1,
                    ]);
                }
            }
        }
    }
}
