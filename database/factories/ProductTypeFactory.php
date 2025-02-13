<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            Image::factory(rand(1, 5))->create(['product_id' => $product->id]);
        });
    }
}
