<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'message',
        'region',
        'follow_up_date',
        'response',
        'remark',
        'demo',
        'admission',
        'teacher_name',
        'feedback',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
    ];
}