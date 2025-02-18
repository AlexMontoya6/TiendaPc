<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use HasFactory;

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function getFormattedPriceAttribute(): float
    {
        // Verificar si el precio es menor que 100 (por ejemplo, datos erróneos)
        if ($this->price < 100) {
            // Registrar el error solo en producción
            if (app()->environment('production')) {
                Log::error("Precio incorrecto para el producto ID: {$this->id}. El precio es menor a 100 céntimos.");
            }

            return 0.00; // Retornar un float válido en caso de error
        }

        // Convertir el precio a euros y devolverlo como float
        return round($this->price / 100, 2);
    }
}
