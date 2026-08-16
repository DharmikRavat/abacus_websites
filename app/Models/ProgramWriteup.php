<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramWriteup extends Model
{
    protected $fillable = [
        
        'paragraph_1',
        'paragraph_2',
        'bullet_points',
        'footer_title',
        'footer_subtitle',
        'footer_image',
        'footer_description',
    ];

    protected $casts = [
        'bullet_points' => 'array',
    ];
}