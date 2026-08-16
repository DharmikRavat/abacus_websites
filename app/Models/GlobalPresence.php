<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalPresence extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_name',
        'country_flag_image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}