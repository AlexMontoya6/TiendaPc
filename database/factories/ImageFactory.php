<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        static $orderByProduct = []; // Para llevar el control del orden por producto

        // Seleccionar un producto aleatorio
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();

        // Definir el orden único para este producto
        $order = $orderByProduct[$product->id] ?? 0;
        $orderByProduct[$product->id] = $order + 1;

        return [
            'product_id' => $product->id,
            'path' => 'products/' . $this->faker->image('storage/app/public/products', 640, 480, null, false),
            'order' => $order, // Asigna el orden único dentro del producto
        ];
    }
}
