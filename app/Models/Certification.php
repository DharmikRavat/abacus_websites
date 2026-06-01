<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    //
    protected $fillable = [
        'trainer_name',
        'certificate_date',
        'level',

        'student_name',
        'parents_name',
        'mobile_no',
        'exam_date',

        'score',
        'result',

        'address',
        'receiver_contact',

        'address_image',
        'certificate_image',

        'dispatch_date',
        'dispatch_id',

        'received_date',
        'remark',

        'download_type',
    ];
}
