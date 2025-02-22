<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\ProductTag;

class TagsSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            ['name' => 'Trending', 'description' => 'Producto en tendencia', 'background_color' => '#FF7F00', 'text_color' => '#FFFFFF', 'border_color' => '#FF7F00', 'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="m381-240 424-424-57-56-368 367-169-170-57 57 227 226Zm0 113L42-466l169-170 170 170 366-367 172 168-538 538Z"/></svg>'],
            ['name' => 'Promoción', 'description' => 'Producto en oferta especial', 'background_color' => '#FFFFFF', 'text_color' => '#FF7F00', 'border_color' => '#FF7F00', 'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>'],
            ['name' => 'Te recomendamos', 'description' => 'Producto destacado', 'background_color' => '#240E81', 'text_color' => '#FFFFFF', 'border_color' => '#240E81', 'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/></svg>'],
            ['name' => 'Nuevo', 'description' => 'Producto recién lanzado', 'background_color' => '#00A650', 'text_color' => '#FFFFFF', 'border_color' => '#00A650', 'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="m344-60-76-128-144-32 14-148-98-112 98-112-14-148 144-32 76-128 136 58 136-58 76 128 144 32-14 148 98 112-98 112 14 148-144 32-76 128-136-58-136 58Zm34-102 102-44 104 44 56-96 110-26-10-112 74-84-74-86 10-112-110-24-58-96-102 44-104-44-56 96-110 24 10 112-74 86 74 84-10 114 110 24 58 96Zm102-318Zm-42 142 226-226-56-58-170 170-86-84-56 56 142 142Z"/></svg>'],
            ['name' => 'Oferta', 'description' => 'Descuento especial', 'background_color' => '#FF0000', 'text_color' => '#FFFFFF', 'border_color' => '#FF0000', 'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/></svg>'],
        ];

        foreach ($tags as $tagData) {
            Tag::create($tagData);
        }

        // 🔹 Crear asociaciones entre productos y etiquetas usando el factory
        ProductTag::factory()->count(20)->create(); // Crea 20 relaciones aleatorias
    }
}
