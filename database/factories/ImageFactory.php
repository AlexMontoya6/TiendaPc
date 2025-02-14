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
        // URL de Picsum para obtener una imagen aleatoria
        $imageUrl = 'https://picsum.photos/640/480';  // Puedes cambiar el tamaño de la imagen aquí
        $imagePath = storage_path('app/public/products/' . uniqid() . '.jpg');  // Ruta completa de la imagen generada

        // Descargar la imagen y guardarla en el directorio especificado
        file_put_contents($imagePath, file_get_contents($imageUrl));

        return [
            'path' => 'products/' . basename($imagePath),  // Guardamos la ruta relativa de la imagen en la base de datos
        ];
    }
}
