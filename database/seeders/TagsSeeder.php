<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Product;
use App\Models\ProductTag;

class TagsSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            ['name' => 'Trending', 'description' => 'Producto en tendencia', 'background_color' => '#FF7F00', 'text_color' => '#FFFFFF', 'border_color' => '#FF7F00'],
            ['name' => 'Promoción', 'description' => 'Producto en oferta especial', 'background_color' => '#FFFFFF', 'text_color' => '#FF7F00', 'border_color' => '#FF7F00'],
            ['name' => 'Te recomendamos', 'description' => 'Producto destacado', 'background_color' => '#240E81', 'text_color' => '#FFFFFF', 'border_color' => '#240E81'],
            ['name' => 'Nuevo', 'description' => 'Producto recién lanzado', 'background_color' => '#00A650', 'text_color' => '#FFFFFF', 'border_color' => '#00A650'],
            ['name' => 'Oferta', 'description' => 'Descuento especial', 'background_color' => '#FF0000', 'text_color' => '#FFFFFF', 'border_color' => '#FF0000'],
        ];

        foreach ($tags as $tagData) {
            Tag::firstOrCreate($tagData);
        }

        // Asignar etiquetas "Oferta" y "Trending" a 12 productos mínimo sin duplicados
        $ofertaTag = Tag::where('name', 'Oferta')->first();
        $trendingTag = Tag::where('name', 'Trending')->first();

        if ($ofertaTag) {
            $ofertaProducts = Product::inRandomOrder()->take(12)->get();
            foreach ($ofertaProducts as $product) {
                if (!ProductTag::where('product_id', $product->id)->where('tag_id', $ofertaTag->id)->exists()) {
                    ProductTag::create([
                        'product_id' => $product->id,
                        'tag_id' => $ofertaTag->id,
                        'is_active' => true,
                    ]);
                }
            }
        }

        if ($trendingTag) {
            $trendingProducts = Product::inRandomOrder()->take(12)->get();
            foreach ($trendingProducts as $product) {
                if (!ProductTag::where('product_id', $product->id)->where('tag_id', $trendingTag->id)->exists()) {
                    ProductTag::create([
                        'product_id' => $product->id,
                        'tag_id' => $trendingTag->id,
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Crear otras relaciones aleatorias sin duplicados
        for ($i = 0; $i < 20; $i++) {
            $randomProduct = Product::inRandomOrder()->first();
            $randomTag = Tag::inRandomOrder()->first();

            if ($randomProduct && $randomTag) {
                if (!ProductTag::where('product_id', $randomProduct->id)->where('tag_id', $randomTag->id)->exists()) {
                    ProductTag::create([
                        'product_id' => $randomProduct->id,
                        'tag_id' => $randomTag->id,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
