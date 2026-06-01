<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'user_image',
        'description_one',
        'abacus_advantage',
        'advantage_image',
        'vision',
        'mission',
    ];

    protected $casts = [
        'vision' => 'array',
        'mission' => 'array',
    ];
}
