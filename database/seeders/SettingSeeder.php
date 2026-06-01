<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            /*
            |--------------------------------------------------------------------------
            | Company Details
            |--------------------------------------------------------------------------
            */
            'company_name' => 'Servicool',
            'company_email' => 'info@servicool.in',
            'company_phone' => '9876543210',
            'company_address' => 'Baner Road, Pune, Maharashtra, India',
            'company_logo' => 'uploads/company/logo.png',
            'company_gst_number' => '27ABCDE1234F1Z5',
            'company_pan_number' => 'ABCDE1234F',
            'company_website' => 'https://servicool.in',

            /*
            |--------------------------------------------------------------------------
            | Notification Settings
            |--------------------------------------------------------------------------
            */
            'email_notifications' => true,
            'sms_notifications' => false,
            'push_notifications' => true,
            'whatsapp_notifications' => true,

            /*
            |--------------------------------------------------------------------------
            | Login/Security Settings
            |--------------------------------------------------------------------------
            */
            'otp_login_enabled' => true,
            'google_login_enabled' => false,
            'facebook_login_enabled' => false,
            'two_factor_auth' => false,
            'session_timeout_minutes' => 30,

            /*
            |--------------------------------------------------------------------------
            | API Keys
            |--------------------------------------------------------------------------
            */
            'google_maps_api_key' => 'GOOGLE_MAPS_API_KEY_SAMPLE',
            'razorpay_key' => 'rzp_test_xxxxxxxxx',
            'razorpay_secret' => 'razorpay_secret_sample',
            'stripe_public_key' => 'pk_test_xxxxxxxx',
            'stripe_secret_key' => 'sk_test_xxxxxxxx',

            /*
            |--------------------------------------------------------------------------
            | Firebase Settings
            |--------------------------------------------------------------------------
            */
            'firebase_api_key' => 'firebase_api_key_sample',
            'firebase_project_id' => 'servicool-project',
            'firebase_sender_id' => '1234567890',
            'firebase_app_id' => '1:1234567890:web:abcdef123456',
            'firebase_server_key' => 'firebase_server_key_sample',

            /*
            |--------------------------------------------------------------------------
            | System Settings
            |--------------------------------------------------------------------------
            */
            'timezone' => 'Asia/Kolkata',
            'currency' => 'INR',
            'date_format' => 'd-m-Y',
        ]);
    }
}