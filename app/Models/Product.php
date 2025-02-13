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

    public function image(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function getFormattedPriceAttribute()
    {
        // Verificar si el precio es menor que 100 (por ejemplo, datos erróneos)
        if ($this->price < 100) {
            // Registrar el error solo en producción
            if (app()->environment('production')) {
                Log::error("Precio incorrecto para el producto ID: {$this->id}. El precio es menor a 100 céntimos.");
            }

            return "Error: El precio del producto {$this->name} con ID: {$this->id}, es incorrecto, debe ser mayor o igual a 100 céntimos.";
        }

        // Obtener el símbolo de la moneda desde el archivo de idioma
        $currencySymbol = __('messages.currency_symbol');

        // Formatear el precio a euros (dividido entre 100), agregar el número seguido del símbolo de la moneda
        return number_format($this->price / 100, 2, '.', ',') . ' ' . $currencySymbol;
    }
}
