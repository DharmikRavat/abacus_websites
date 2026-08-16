<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'course_count',
        'teachers_count',
        'members_count',
        'countries_count',
    ];
}
