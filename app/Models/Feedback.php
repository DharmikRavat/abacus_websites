<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'user_id',
        'message',
        'rating',
        'status',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
}
