<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentFeeRecord extends Model
{
    //
    protected $fillable = [
        'student_enrollment_id',
        'financial_year',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
        'january',
        'february',
        'march',
        'total_amount',
        'remark'
    ];

    public function student()
    {
        return $this->belongsTo(Customer::class,'student_enrollment_id','student_enrollment_id');
    }
}
