<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAdmission extends Model
{
    protected $fillable = [
        'teacher_id',
        'teacher_name',
        'mobile_no',
        'trainer_name',
        'address',
        'region',
        'admission_date',

        'junior_amount',

        'level_01_amount',
        'level_02_amount',
        'level_03_amount',
        'level_04_amount',
        'level_05_amount',
        'level_06_amount',
        'level_07_amount',
        'level_08_amount',
        'level_09_amount',
        'level_10_amount',

        'remark',
    ];

    protected $casts = [
        'admission_date' => 'date',

        'junior_amount' => 'decimal:2',

        'level_01_amount' => 'decimal:2',
        'level_02_amount' => 'decimal:2',
        'level_03_amount' => 'decimal:2',
        'level_04_amount' => 'decimal:2',
        'level_05_amount' => 'decimal:2',
        'level_06_amount' => 'decimal:2',
        'level_07_amount' => 'decimal:2',
        'level_08_amount' => 'decimal:2',
        'level_09_amount' => 'decimal:2',
        'level_10_amount' => 'decimal:2',
    ];
}