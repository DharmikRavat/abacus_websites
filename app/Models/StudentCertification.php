<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCertification extends Model
{
    //
    protected $table = "student_certificates";
    protected $fillable = [
        'certificate_unique_id',
        'title',
        'file',
        'student_enrollment_id',
        'added_by',
    ];
    public function student()
{
    return $this->belongsTo(Customer::class, 'student_enrollment_id', 'student_enrollment_id');
}
}
