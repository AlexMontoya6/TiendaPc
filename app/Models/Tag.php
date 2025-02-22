<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'background_color', 'text_color', 'border_color', 'icon_svg'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_tag')
            ->withPivot('ttl', 'is_active')
            ->withTimestamps();
    }

    public function activeProducts(): BelongsToMany
    {
        return $this->products()
            ->wherePivot('is_active', true)
            ->where(function ($query) {
                $query->whereNull('ttl')->orWhere('ttl', '>', now());
            });
    }

    public static function ofertaProducts()
    {
        return self::where('name', 'Oferta')->first()?->activeProducts()->take(10)->get() ?? collect();
    }

    // Scope para obtener productos trending (máximo 10)
    public static function trendingProducts()
    {
        return self::where('name', 'Trending')->first()?->activeProducts()->take(10)->get() ?? collect();
    }
}
