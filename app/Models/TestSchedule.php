<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSchedule extends Model
{
    use HasFactory;
    protected $table = 'test_schedules';
    protected $fillable = [
        'test_type',
        'exam_level',
        'schedule_date',
        'schedule_exam_type',
        'no_of_questions',
        'schedule_time',
        'schedule_password',
    ];

    protected $casts = [
        'schedule_date' => 'date',
        'schedule_time' => 'string',
    ];
}
