<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

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
        return $this->hasMany(Image::class)->orderBy('order', 'asc');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)
            ->withPivot('expires_at', 'is_active')
            ->withTimestamps();
    }

    public function activeTags(): Collection
    {
        return $this->tags()->wherePivot('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })->get();
    }

    public function getFormattedPriceAttribute(): float
    {
        if ($this->price < 100) {
            if (app()->environment('local')) {
                throw new \Exception("Precio incorrecto para el producto ID: {$this->id}. Es menor a 100 céntimos.");
            } else {
                Log::error("Precio incorrecto para el producto ID: {$this->id}. Es menor a 100 céntimos.");
                return 0.00;
            }
        }

        return (float) bcdiv($this->price, '100', 2);
    }
}
