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
            ['name' => 'Trending', 'description' => 'Producto en tendencia', 'background_color' => '#FF7F00', 'text_color' => '#FFFFFF', 'border_color' => '#FF7F00', 'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="m136-240-56-56 296-298 160 160 208-206H640v-80h240v240h-80v-104L536-320 376-480 136-240Z"/></svg>'],
            ['name' => 'Promoción', 'description' => 'Producto en oferta especial', 'background_color' => '#FFFFFF', 'text_color' => '#FF7F00', 'border_color' => '#FF7F00', 'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>'],
            ['name' => 'Te recomendamos', 'description' => 'Producto destacado', 'background_color' => '#240E81', 'text_color' => '#FFFFFF', 'border_color' => '#240E81', 'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="M475-160q4 0 8-2t6-4l328-328q12-12 17.5-27t5.5-30q0-16-5.5-30.5T817-607L647-777q-11-12-25.5-17.5T591-800q-15 0-30 5.5T534-777l-11 11 74 75q15 14 22 32t7 38q0 42-28.5 70.5T527-522q-20 0-38.5-7T456-550l-75-74-175 175q-3 3-4.5 6.5T200-435q0 8 6 14.5t14 6.5q4 0 8-2t6-4l136-136 56 56-135 136q-3 3-4.5 6.5T285-350q0 8 6 14t14 6q4 0 8-2t6-4l136-135 56 56-135 136q-3 2-4.5 6t-1.5 8q0 8 6 14t14 6q4 0 7.5-1.5t6.5-4.5l136-135 56 56-136 136q-3 3-4.5 6.5T454-180q0 8 6.5 14t14.5 6Zm-1 80q-37 0-65.5-24.5T375-166q-34-5-57-28t-28-57q-34-5-56.5-28.5T206-336q-38-5-62-33t-24-66q0-20 7.5-38.5T149-506l232-231 131 131q2 3 6 4.5t8 1.5q9 0 15-5.5t6-14.5q0-4-1.5-8t-4.5-6L398-777q-11-12-25.5-17.5T342-800q-15 0-30 5.5T285-777L144-635q-9 9-15 21t-8 24q-2 12 0 24.5t8 23.5l-58 58q-17-23-25-50.5T40-590q2-28 14-54.5T87-692l141-141q24-23 53.5-35t60.5-12q31 0 60.5 12t52.5 35l11 11 11-11q24-23 53.5-35t60.5-12q31 0 60.5 12t52.5 35l169 169q23 23 35 53t12 61q0 31-12 60.5T873-437L545-110q-14 14-32.5 22T474-80Zm-99-560Z"/></svg>'],
            ['name' => 'Nuevo', 'description' => 'Producto recién lanzado', 'background_color' => '#00A650', 'text_color' => '#FFFFFF', 'border_color' => '#00A650', 'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="m344-60-76-128-144-32 14-148-98-112 98-112-14-148 144-32 76-128 136 58 136-58 76 128 144 32-14 148 98 112-98 112 14 148-144 32-76 128-136-58-136 58Zm34-102 102-44 104 44 56-96 110-26-10-112 74-84-74-86 10-112-110-24-58-96-102 44-104-44-56 96-110 24 10 112-74 86 74 84-10 114 110 24 58 96Zm102-318Zm-42 142 226-226-56-58-170 170-86-84-56 56 142 142Z"/></svg>'],
            ['name' => 'Rebajas', 'description' => 'Producto con descuento', 'background_color' => '#FF0000', 'text_color' => '#FFFFFF', 'border_color' => '#FF0000', 'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/></svg>'],
            ['name' => 'Oferta', 'description' => 'Descuento especial', 'background_color' => '#FF0000', 'text_color' => '#FFFFFF', 'border_color' => '#FF0000', 'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/></svg>'],
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
