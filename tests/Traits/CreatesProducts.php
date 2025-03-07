<?php

namespace Tests\Traits;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Subcategory;
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

        // Asegurar que existen un ProductType, Category y Subcategory
        $productType = ProductType::first() ?? ProductType::factory()->create();
        $category = Category::first() ?? Category::factory()->create();
        $subcategory = Subcategory::first() ?? Subcategory::factory()->create(['category_id' => $category->id]);

        // Crear el producto asegurando que tiene categoría y subcategoría
        $product = Product::factory()->create([
            'product_type_id' => $productType->id,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        // Crear la imagen asociada
        $imageName = uniqid().'.jpg';
        $imagePath = 'products/'.$imageName;

        Storage::disk('public')->put($imagePath, file_get_contents('https://picsum.photos/640/480'));

        Image::factory()->create([
            'path' => $imagePath,
            'product_id' => $product->id,
            'order' => 1, // Evitamos problemas con claves únicas
        ]);

        return $product;
    }
}
