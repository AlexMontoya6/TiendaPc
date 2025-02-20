<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\Tag;
use Carbon\Carbon;

class ProductTagFactory extends Factory
{
    /**
     * Define el modelo correspondiente.
     *
     * @var string
     */
    protected $model = ProductTag::class;

    /**
     * Define el estado por defecto del factory.
     */
    public function definition()
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'tag_id' => Tag::inRandomOrder()->first()->id,
            'ttl' => $this->faker->boolean(50) ? Carbon::now()->addDays(rand(5, 30)) : null, // 50% de etiquetas tienen expiración
            'is_active' => $this->faker->boolean(80), // 80% de las etiquetas estarán activas
        ];
    }
}
