<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    //

    protected $fillable = [
        'title',
        'media_type',
        'media',
        'youtube_link',
        'is_active',
        'is_dashboard',
    ];
}
