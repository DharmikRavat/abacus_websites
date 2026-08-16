<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'is_active',
        'image',
        'link',
        'program_images',
    ];

    protected $casts = [
        'program_images' => 'array',
        'is_active' => 'boolean',
    ];
}