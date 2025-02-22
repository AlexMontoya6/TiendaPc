<?php

namespace Tests\Traits;

use App\Models\ProductType;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

trait CreatesProducts
{
    /**
     * Crea un producto con su tipo y una imagen asociada.
     */
    public function newProduct(): Product
    {
        // Simulamos el sistema de almacenamiento
        Storage::fake('public');

        // Asegurar que existe un ProductType
        $productType = ProductType::first() ?? ProductType::factory()->create();

        // Crear el producto
        $product = Product::factory()->create([
            'product_type_id' => $productType->id,
        ]);

        // Crear la imagen asociada
        $imageName = uniqid() . '.jpg';
        $imagePath = 'products/' . $imageName;

        Storage::disk('public')->put($imagePath, file_get_contents('https://picsum.photos/640/480'));

        Image::factory()->create([
            'path' => $imagePath,
            'product_id' => $product->id,
            'order' => 1, // Evitamos problemas con claves únicas
        ]);

        return $product;
    }
}
