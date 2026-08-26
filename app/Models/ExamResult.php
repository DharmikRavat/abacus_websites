<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'score_id',
        'result',
        'remark',
        'declared_by',
        'declared_at',
    ];

    protected $casts = [
        'declared_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Customer::class);
    }

    public function score()
    {
        return $this->belongsTo(Score::class);
    }

    public function declaredBy()
    {
        return $this->belongsTo(User::class, 'declared_by');
    }
}