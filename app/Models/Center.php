<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    //
    use HasFactory;
    protected $fillable = [

        'country_name',

        'state_name',

        'district_name',

        'center_name',

        'center_address',

        'center_contact',

        'assigned_teacher_id',

        'assigned_teacher_name',

        'assigned_teacher_about',

    ];

    /*
    |--------------------------------------------------------------------------
    | Teacher Relation
    |--------------------------------------------------------------------------
    */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'assigned_teacher_id');
    }
}
