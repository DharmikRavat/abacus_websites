<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'item_name',
        'item_brand',
        'item_type',
        'item_description',
        'discount_on_item',
        'item_price',
        'item_qty',
        'item_image',
        'status',
    ];

    protected $casts = [
        'discount_on_item' => 'decimal:2',
        'item_price' => 'decimal:2',
        'item_qty' => 'integer',
        'status' => 'boolean',
    ];
}