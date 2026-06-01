<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamLevel extends Model
{
    use HasFactory;
    protected $table = 'exam_levels';
    protected $fillable = [
        'difficulty',
        'level',
        'is_active'
    ];
}
