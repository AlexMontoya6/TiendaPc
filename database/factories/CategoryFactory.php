<?php

namespace Database\Factories;

use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productType = ProductType::first();

        if (!$productType) {
            throw new \Exception("Debe existir al menos un ProductType en la base de datos.");
        }

        return [
            'name' => 'Categoria ' . $this->faker->unique()->word(),
            'slug' => 'categoria-' . $this->faker->unique()->slug(),
            'description' => $this->faker->sentence(),
            'product_type_id' => $productType ? $productType->id : null,
        ];
    }
}
