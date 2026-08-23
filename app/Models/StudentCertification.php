<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentCertification extends Model
{
    protected $fillable = [
        'student_id',
        'student_name',
        'parents_name',
        'mobile_no',
        'exam_date',
        'level',
        'score',
        'result',
        'address',
        'receiver_name',
        'receiver_contact',
        'address_image',
        'certificate_image',
        'abacus_trainer_name',
        'certificate_date',
        'dispatched_date',
        'dispatched_id',
        'dispatched_link',
        'received_date',
        'remark',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'certificate_date' => 'date',
        'dispatched_date' => 'date',
        'received_date' => 'date',
        'score' => 'decimal:2',
    ];

   
    public function student(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'student_id');
    }
}