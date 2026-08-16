<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'company_logo',
        'company_gst_number',
        'company_pan_number',
        'company_website',

        'email_notifications',
        'sms_notifications',
        'push_notifications',
        'whatsapp_notifications',

        'otp_login_enabled',
        'google_login_enabled',
        'facebook_login_enabled',
        'two_factor_auth',
        'session_timeout_minutes',

        'google_maps_api_key',
        'razorpay_key',
        'razorpay_secret',
        'stripe_public_key',
        'stripe_secret_key',

        'firebase_api_key',
        'firebase_project_id',
        'firebase_sender_id',
        'firebase_app_id',
        'firebase_server_key',

        'timezone',
        'currency',
        'date_format',
        "gmail_url",

"instagram_url",

"whatsapp_url",

"facebook_url",

"youtube_url"
    ];
}