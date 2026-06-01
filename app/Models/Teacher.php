<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    use HasFactory;


    protected $fillable = [

        'name',
        'profile',
        'slug_id',
        'email',
        'email_verified_at',
        'password',
        'type',
        'permissions',
        'status',
        'fcm_id',
        'role',
        'password',
        'remember_token',
        'email_verified_at' => 'datetime',
        'status' => 'boolean',

    ];
}
