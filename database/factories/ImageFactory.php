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
        // Seleccionamos el primer producto encontrado en la base de datos
        $product = Product::first();

        // Si no hay productos en la base de datos, lanzamos una excepción
        if (!$product) {
            throw new \Exception("No hay productos disponibles en la base de datos.");
        }

        // Obtener el siguiente número de orden para el producto
        // Esto garantiza que el siguiente `order` sea único para cada nueva imagen creada
        $existingOrders = Image::where('product_id', $product->id)->pluck('order')->toArray();

        // Generamos el siguiente `order` que no se repita, comenzando desde 1
        $order = 1;

        // Mientras el `order` ya esté en uso, incrementamos el valor
        while (in_array($order, $existingOrders)) {
            $order++;
        }

        return [
            'product_id' => $product->id,  // Usamos el id del primer producto encontrado
            'path' => 'products/' . $this->faker->image('storage/app/public/products', 640, 480, null, false),  // Genera una ruta de imagen
            'order' => $order,  // Asignamos el siguiente número de orden único
        ];
    }
}
