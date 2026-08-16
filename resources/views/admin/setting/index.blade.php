@extends('admin.layout.app')

@section('page-title', 'Settings')

@section('style')
@endsection

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Application Settings</h1>
        <p>Manage company details, notifications, API keys and system settings.</p>
    </div>
</div>


<form action="{{ route('admin.settings.update', $settings->id) }}" 
      method="POST" 
      enctype="multipart/form-data">

    @csrf
    @method('PUT')




    {{-- ================= COMPANY DETAILS ================= --}}
    <div class="form-section">
        <div class="section-header">
            <h3>Academy Details</h3>
            <p>Manage company information and branding</p>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label class="form-label">Academy Name</label>
                <input type="text" name="company_name" class="form-control"
                       value="{{ $settings->company_name ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">Academy Email</label>
                <input type="email" name="company_email" class="form-control"
                       value="{{ $settings->company_email ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">Academy Phone</label>
                <input type="text" name="company_phone" class="form-control"
                       value="{{ $settings->company_phone ?? '' }}">
            </div>

            <div class="form-group full">
                <label class="form-label">Academy Address</label>
                <textarea name="company_address"
                          class="form-control">{{ $settings->company_address ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Website</label>
                <input type="text" name="company_website" class="form-control"
                       value="{{ $settings->company_website ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">GST Number</label>
                <input type="text" name="company_gst_number" class="form-control"
                       value="{{ $settings->company_gst_number ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">PAN Number</label>
                <input type="text" name="company_pan_number" class="form-control"
                       value="{{ $settings->company_pan_number ?? '' }}">
            </div>

            <div class="form-group full">
                <label class="form-label">Academy Logo</label>
                <input type="file" name="company_logo" class="form-control">

                @if($settings->company_logo)
                    <div style="margin-top:10px;">
                        <img src="{{ asset('storage/'.$settings->company_logo) }}"
                             width="100"
                             style="border-radius:10px;">
                    </div>
                @endif
            </div>

        </div>
    </div>


    {{-- ================= NOTIFICATION SETTINGS ================= --}}
    <div class="form-section">
        <div class="section-header">
            <h3>Notification Settings</h3>
            <p>Control how users receive alerts</p>
        </div>

        <div class="form-grid">

            <label class="toggle-row">
                <div>
                    <div class="toggle-row-label">Email Notifications</div>
                    <div class="toggle-row-sub">Send notifications via email</div>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="email_notifications"
                        {{ $settings->email_notifications ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </label>

            <label class="toggle-row">
                <div>
                    <div class="toggle-row-label">SMS Notifications</div>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="sms_notifications"
                        {{ $settings->sms_notifications ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </label>

            <label class="toggle-row">
                <div>
                    <div class="toggle-row-label">Push Notifications</div>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="push_notifications"
                        {{ $settings->push_notifications ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </label>

            <label class="toggle-row">
                <div>
                    <div class="toggle-row-label">WhatsApp Notifications</div>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="whatsapp_notifications"
                        {{ $settings->whatsapp_notifications ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </label>

        </div>
    </div>


    {{-- ================= LOGIN SETTINGS ================= --}}
    <div class="form-section">
        <div class="section-header">
            <h3>Login Settings</h3>
            <p>Configure authentication options</p>
        </div>

        <div class="form-grid">

            @php
                $loginSettings = [
                    'otp_login_enabled' => 'OTP Login',
                    'google_login_enabled' => 'Google Login',
                    'facebook_login_enabled' => 'Facebook Login',
                    'two_factor_auth' => 'Two Factor Authentication'
                ];
            @endphp

            @foreach($loginSettings as $key => $label)
                <label class="toggle-row">
                    <div>
                        <div class="toggle-row-label">{{ $label }}</div>
                    </div>

                    <label class="toggle">
                        <input type="checkbox"
                               name="{{ $key }}"
                               {{ $settings->$key ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </label>
            @endforeach

        </div>
    </div>


    {{-- ================= API SETTINGS ================= --}}
    <div class="form-section">
        <div class="section-header">
            <h3>API Keys</h3>
            <p>Manage third-party integrations</p>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label class="form-label">Google Maps API Key</label>
                <input type="text" name="google_maps_api_key"
                       class="form-control"
                       value="{{ $settings->google_maps_api_key ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">Razorpay Key</label>
                <input type="text" name="razorpay_key"
                       class="form-control"
                       value="{{ $settings->razorpay_key ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">Razorpay Secret</label>
                <input type="text" name="razorpay_secret"
                       class="form-control"
                       value="{{ $settings->razorpay_secret ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">Stripe Public Key</label>
                <input type="text" name="stripe_public_key"
                       class="form-control"
                       value="{{ $settings->stripe_public_key ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">Stripe Secret Key</label>
                <input type="text" name="stripe_secret_key"
                       class="form-control"
                       value="{{ $settings->stripe_secret_key ?? '' }}">
            </div>

        </div>
    </div>


    {{-- ================= FIREBASE SETTINGS ================= --}}
    <div class="form-section">
        <div class="section-header">
            <h3>Firebase Settings</h3>
            <p>Push notification & mobile integration setup</p>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label class="form-label">Firebase API Key</label>
                <input type="text" name="firebase_api_key" class="form-control"
                       value="{{ $settings->firebase_api_key ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">Project ID</label>
                <input type="text" name="firebase_project_id" class="form-control"
                       value="{{ $settings->firebase_project_id ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">Sender ID</label>
                <input type="text" name="firebase_sender_id" class="form-control"
                       value="{{ $settings->firebase_sender_id ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">App ID</label>
                <input type="text" name="firebase_app_id" class="form-control"
                       value="{{ $settings->firebase_app_id ?? '' }}">
            </div>

            <div class="form-group full">
                <label class="form-label">Server Key</label>
                <input type="text" name="firebase_server_key" class="form-control"
                       value="{{ $settings->firebase_server_key ?? '' }}">
            </div>

        </div>
    </div>

{{-- ================= SOCIAL MEDIA URLS ================= --}}
<div class="form-section">
    <div class="section-header">
        <h3>Social Media URLs</h3>
        <p>Manage your website and social media profile links</p>
    </div>

    <div class="form-grid">

        <div class="form-group">
            <label class="form-label">Facebook URL</label>
            <input type="url"
                   name="facebook_url"
                   class="form-control"
                   placeholder="https://facebook.com/yourpage"
                   value="{{ $settings->facebook_url ?? '' }}">
        </div>

        <div class="form-group">
            <label class="form-label">Instagram URL</label>
            <input type="url"
                   name="instagram_url"
                   class="form-control"
                   placeholder="https://instagram.com/yourprofile"
                   value="{{ $settings->instagram_url ?? '' }}">
        </div>

        <div class="form-group">
            <label class="form-label">YouTube URL</label>
            <input type="url"
                   name="youtube_url"
                   class="form-control"
                   placeholder="https://youtube.com/@yourchannel"
                   value="{{ $settings->youtube_url ?? '' }}">
        </div>

        <div class="form-group">
            <label class="form-label">WhatsApp URL</label>
            <input type="url"
                   name="whatsapp_url"
                   class="form-control"
                   placeholder="https://wa.me/919876543210"
                   value="{{ $settings->whatsapp_url ?? '' }}">
        </div>

        <div class="form-group full">
            <label class="form-label">Gmail / Contact Email</label>
            <input type="email"
                   name="gmail_url"
                   class="form-control"
                   placeholder="contact@example.com"
                   value="{{ $settings->gmail_url ?? '' }}">
        </div>

    </div>
</div>



    {{-- FOOTER SAVE --}}
    <div class="card" style="padding:20px;text-align:right;">
        <button type="submit" class="btn btn-primary">
            Save All Settings
        </button>
    </div>

</form>




@endsection

@section('script')
@endsection