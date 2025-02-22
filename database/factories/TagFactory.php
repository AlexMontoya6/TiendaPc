<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'background_color' => $this->faker->hexColor(),
            'text_color' => $this->faker->hexColor(),
            'border_color' => $this->faker->hexColor(),
            'icon_svg' => null,
        ];
    }
}
