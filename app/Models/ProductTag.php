<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTag extends Model
{
    use HasFactory;

    protected $table = 'product_tag';

    public $timestamps = false;

    protected $fillable = ['product_id', 'tag_id', 'ttl', 'is_active'];

    // 🔥 Relaciones con Product y Tag
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($productTag) {
            $exists = self::where('product_id', $productTag->product_id)
                ->where('tag_id', $productTag->tag_id)
                ->exists();

            if ($exists) {
                throw new \Exception('El producto ya tiene esta etiqueta asignada.');
            }
        });
    }
}
