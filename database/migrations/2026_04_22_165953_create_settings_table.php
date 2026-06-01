<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Company Details
            |--------------------------------------------------------------------------
            */
            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_gst_number')->nullable();
            $table->string('company_pan_number')->nullable();
            $table->string('company_website')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Notification Settings
            |--------------------------------------------------------------------------
            */
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(false);
            $table->boolean('push_notifications')->default(true);
            $table->boolean('whatsapp_notifications')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Login/Security Settings
            |--------------------------------------------------------------------------
            */
            $table->boolean('otp_login_enabled')->default(false);
            $table->boolean('google_login_enabled')->default(false);
            $table->boolean('facebook_login_enabled')->default(false);
            $table->boolean('two_factor_auth')->default(false);
            $table->integer('session_timeout_minutes')->default(30);

            /*
            |--------------------------------------------------------------------------
            | API Keys
            |--------------------------------------------------------------------------
            */
            $table->text('google_maps_api_key')->nullable();
            $table->text('razorpay_key')->nullable();
            $table->text('razorpay_secret')->nullable();
            $table->text('stripe_public_key')->nullable();
            $table->text('stripe_secret_key')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Firebase Settings
            |--------------------------------------------------------------------------
            */
            $table->text('firebase_api_key')->nullable();
            $table->string('firebase_project_id')->nullable();
            $table->string('firebase_sender_id')->nullable();
            $table->string('firebase_app_id')->nullable();
            $table->text('firebase_server_key')->nullable();

            /*
            |--------------------------------------------------------------------------
            | System Settings
            |--------------------------------------------------------------------------
            */
            $table->string('timezone')->nullable();
            $table->string('currency')->nullable();
            $table->string('date_format')->default('d-m-Y');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
