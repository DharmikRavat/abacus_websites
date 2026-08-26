<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestReport extends Model
{
    protected $fillable = [
        'student_id',
        'student_name',
        'enrollment_id',
        'trainer_name',
        'report_type',
        'test_name',
        'test_number',
        'level',
        'report_date',
        'total_time',
        'total_questions',
        'correct',
        'wrong',
        'skipped',
        'result',
        'remark',
        'work_remark',
        'parent_message',
        'status',
    ];

    protected $casts = [
        'report_date' => 'date',
    ];
    public function students()
    {
        return $this->hasMany(TestReport::class);
    }
}