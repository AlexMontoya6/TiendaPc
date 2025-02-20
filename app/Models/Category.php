<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{

    use HasFactory;

    public function ProductType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function Subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
    }
}
