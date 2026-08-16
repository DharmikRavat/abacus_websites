<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    use HasFactory;
     protected $fillable = [

        'name',
        'slug',
        'slug_id',
        'auth_id',
        'email',
        'password',
        'mobile',
        'profile',
        'address',
        'fcm_id',
        'logintype',
        'is_email_verified',
        'isActive',
        'api_token',
        'notification',
        'subscription',
        'about_me',
        'facebook_id',
        'twiiter_id',
        'instagram_id',
        'youtube_id',
        'latitude',
        'longitude',
        'city',
        'state',
        'country',
        'is_premium',
        'role',
        'added_by',
        'center_id',
        'is_email_verified' => 'boolean',
        'isActive'          => 'boolean',
        'notification'      => 'boolean',
        'is_premium'        => 'boolean',
        'subscription'      => 'boolean',
        'password',
        'api_token',
        'student_enrollment_id'
    ];


    

}
