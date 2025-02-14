<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Image;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $productType = ProductType::first();

        if (!$productType) {
            throw new \Exception("Debe existir al menos un ProductType en la base de datos.");
        }

        $category = Category::inRandomOrder()->first();

        $subcategory = Subcategory::inRandomOrder()->first();

        return [
            'name' => $this->faker->word(),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100, 100000),
            'product_type_id' => $productType->id,
            'category_id' => $category ? $category->id : null,
            'subcategory_id' => $subcategory ? $subcategory->id : null,
        ];
    }
}
