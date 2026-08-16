<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Show settings page
     */
    public function index()
    {
        $settings = Setting::first();

        // Create default row if no settings exist
        if (!$settings) {
            $settings = Setting::create([]);
        }

        return view('admin.setting.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $settings = Setting::first();

        if (!$settings) {
            $settings = Setting::create([]);
        }

        $request->validate([
            // Company
            'company_name' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'company_gst_number' => 'nullable|string|max:100',
            'company_pan_number' => 'nullable|string|max:100',
            'company_website' => 'nullable|string|max:255',

            // API Keys
            'google_maps_api_key' => 'nullable|string',
            'razorpay_key' => 'nullable|string',
            'razorpay_secret' => 'nullable|string',
            'stripe_public_key' => 'nullable|string',
            'stripe_secret_key' => 'nullable|string',

            // Firebase
            'firebase_api_key' => 'nullable|string',
            'firebase_project_id' => 'nullable|string',
            'firebase_sender_id' => 'nullable|string',
            'firebase_app_id' => 'nullable|string',
            'firebase_server_key' => 'nullable|string',

            // System
            'timezone' => 'nullable|string',
            'currency' => 'nullable|string',
            'date_format' => 'nullable|string',
            "instagram_url" => 'nullable|string',

"whatsapp_url" => 'nullable|string',

"gmail_url" => 'nullable|string',

"youtube_url" => 'nullable|string',
"facebook_url" => 'nullable|string',
        ]);

        $data = $request->except('company_logo');

        /*
        |--------------------------------------------------------------------------
        | Handle Logo Upload
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('company_logo')) {

            // Delete old logo
            if ($settings->company_logo && Storage::exists($settings->company_logo)) {
                Storage::delete($settings->company_logo);
            }

            $logoPath = $request->file('company_logo')
                ->store('company-logos', 'public');

            $data['company_logo'] = $logoPath;
        }

        /*
        |--------------------------------------------------------------------------
        | Boolean Fields
        |--------------------------------------------------------------------------
        */
        $data['email_notifications'] = $request->has('email_notifications');
        $data['sms_notifications'] = $request->has('sms_notifications');
        $data['push_notifications'] = $request->has('push_notifications');
        $data['whatsapp_notifications'] = $request->has('whatsapp_notifications');

        $data['otp_login_enabled'] = $request->has('otp_login_enabled');
        $data['google_login_enabled'] = $request->has('google_login_enabled');
        $data['facebook_login_enabled'] = $request->has('facebook_login_enabled');
        $data['two_factor_auth'] = $request->has('two_factor_auth');

        $settings->update($data);

        return redirect()
            ->back()
            ->with('success', 'Settings updated successfully.');
    }
}