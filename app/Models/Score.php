<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Score extends Model
{
    use HasFactory;
    protected $table = 'scores';
    protected $fillable = [
        'score_unique_id',
        'exam_type',
        'user_id',
        'center_id',
        'total',
        'correct',
        'wrong',
        'skipped',
        'time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function booted()
    {
        static::creating(function ($score) {
            if (empty($score->score_unique_id)) {
                $score->score_unique_id = 'SCR-' . strtoupper(Str::random(10));
            }
        });
    }
    public function customer()
{
    return $this->belongsTo(Customer::class, 'user_id');
}
}
