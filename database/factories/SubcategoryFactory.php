<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subcategory>
 */
class SubcategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $category = Category::first();

        if (! $category) {
            throw new \Exception('Debe existir al menos una Category en la base de datos.');
        }

        return [
            'name' => 'Subcategoría '.$this->faker->unique()->word(),
            'slug' => 'subcategoria-'.$this->faker->unique()->slug(),
            'category_id' => $category ? $category->id : null,
        ];
    }
}
