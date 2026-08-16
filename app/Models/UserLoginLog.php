<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
    //
    protected $fillable = [
        'user_id',
        'login_from',
        'browser',
        'browser_version',
        'os',
        'os_version',
        'device',
        'device_type',
        'ip',
        'user_agent',
        'latitude',
        'longitude',
        'login_at'
    ];
    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
}
