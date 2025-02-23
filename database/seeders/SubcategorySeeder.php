<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ProductType;
use App\Models\Subcategory;
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
        // 🔹 Obtener todos los tipos de producto en la base de datos
        $productTypes = ProductType::all();

        foreach ($productTypes as $productType) {
            $categories = Category::where('product_type_id', $productType->id)->get();

            foreach ($categories as $category) {
                // 🔹 Generar entre 1 y 5 subcategorías por categoría
                $numSubcategories = rand(1, 5);

                Subcategory::factory($numSubcategories)->create([
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
