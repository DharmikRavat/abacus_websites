<?php

namespace App\Helpers;

use App\Models\UserLoginLog;
use Jenssegers\Agent\Agent;

class LoginLogger
{
    public static function log($user, $latitude = null, $longitude = null)
    {
        $agent = new Agent();

        UserLoginLog::create([
            'user_id' => $user->id,

            'login_from' => $agent->isDesktop()
                ? 'web'
                : ($agent->isMobile() ? 'mobile' : 'tablet'),

            'browser' => $agent->browser(),

            'browser_version' => $agent->version($agent->browser()),

            'os' => $agent->platform(),

            'os_version' => $agent->version($agent->platform()),

            'device' => $agent->device(),

            'device_type' => $agent->isDesktop()
                ? 'Desktop'
                : ($agent->isTablet() ? 'Tablet' : 'Mobile'),

            'ip' => request()->ip(),

            'user_agent' => request()->userAgent(),

            'latitude' => $latitude,

            'longitude' => $longitude,

            'login_at' => now(),
        ]);
    }
}