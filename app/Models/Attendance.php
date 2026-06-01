<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    use HasFactory;

    protected $fillable = [

        'student_id',
        'mark_by_id',
        'attendance_date',
        'status',
        'remark',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // student attendance
    public function student()
    {
        return $this->belongsTo(Customer::class);
    }

    // admin/teacher who marked attendance
    public function markedBy()
    {
        return $this->belongsTo(User::class, 'mark_by_id');
    }
}
