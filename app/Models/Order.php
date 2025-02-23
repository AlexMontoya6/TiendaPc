<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shipping_name',
        'shipping_street',
        'shipping_city',
        'shipping_postal_code',
        'shipping_country',
        'delivery_option',
        'payment_method',
        'total_price',
        'status',
    ];
}
