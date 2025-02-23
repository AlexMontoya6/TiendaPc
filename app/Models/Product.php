<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'price', 'product_type_id', 'category_id', 'subcategory_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

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
        return $this->hasMany(Image::class)->orderBy('order', 'asc');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tag')
            ->withPivot('ttl', 'is_active')
            ->withTimestamps();
    }

    public function activeTags(): Collection
    {
        return $this->tags()
            ->wherePivot('is_active', true)
            ->where(function ($query) {
                $query->whereNull('ttl')
                    ->orWhere('ttl', '>', now());
            })
            ->get();
    }

    public function getFormattedPriceAttribute(): ?float
    {
        if ($this->price < 100) {
            Log::error("Precio incorrecto para el producto ID: {$this->id}. Es menor a 100 céntimos.");

            return null; // 🔹 Mejor que lanzar una excepción en producción
        }

        return (float) bcdiv($this->price, '100', 2);
    }
}
