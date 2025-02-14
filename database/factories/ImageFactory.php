<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'path' => 'products/' . $this->faker->image('storage/app/public/products', 640, 480, null, false),  // Genera una ruta de imagen
        ];
    }
}
