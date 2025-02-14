<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productTypes = ['Componentes', 'Ordenadores', 'Periféricos'];

        foreach ($productTypes as $productTypeName) {
            $productType = ProductType::where('name', $productTypeName)->first();

            if (!$productType) {
                continue;
            }

            $categories = Category::where('product_type_id', $productType->id)->get();

            foreach ($categories as $category) {
                if (rand(0, 1)) {
                    Subcategory::factory()->create([
                        'category_id' => $category->id,
                    ]);
                }
            }
        }
    }
}
