<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;

    protected $table = 'product_tag';
    public $timestamps = false;

    // Definir clave única para evitar duplicados
    protected $primaryKey = ['product_id', 'tag_id'];
    public $incrementing = false;
    protected $fillable = ['product_id', 'tag_id', 'ttl', 'is_active'];

    // Validación en Laravel para evitar duplicados antes de guardar
    public static function boot()
    {
        parent::boot();

        static::creating(function ($productTag) {
            if (self::where('product_id', $productTag->product_id)
                ->where('tag_id', $productTag->tag_id)
                ->exists()) {
                return false; // Cancelar la creación si ya existe
            }
        });
    }
}
