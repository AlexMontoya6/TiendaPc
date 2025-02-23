<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transformar el recurso en un array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => number_format($this->price, 2), // 💰 Formateamos el precio
            'description' => $this->description,
            'available' => $this->stock > 0, // ✅ Indicamos si hay stock o no
            'category' => $this->category->name ?? null, // 📁 Incluimos la categoría
            'created_at' => $this->created_at->toIso8601String(), // 🕒 Fecha estándar
        ];
    }
}
