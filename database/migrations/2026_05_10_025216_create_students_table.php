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
        Schema::create('students', function (Blueprint $table) {
            
            $table->id();

            $table->string('name')->nullable();

            $table->string('slug')->nullable();

            $table->uuid('slug_id')->nullable();

            $table->uuid('auth_id')->nullable();

            $table->string('email')->nullable();

            $table->string('password')->nullable();

            $table->string('mobile')->nullable();

            $table->string('profile')->nullable();

            $table->text('address')->nullable();

            $table->text('fcm_id')->nullable();

            $table->integer('logintype')->default(1);

            $table->boolean('is_email_verified')->default(false);

            $table->boolean('isActive')->default(true);

            $table->text('api_token')->nullable();

            $table->boolean('notification')->default(true);

            $table->boolean('subscription')->default(false);

            $table->text('about_me')->nullable();

            $table->string('facebook_id')->nullable();

            $table->string('twiiter_id')->nullable();

            $table->string('instagram_id')->nullable();

            $table->string('youtube_id')->nullable();

            $table->string('latitude')->nullable();

            $table->string('longitude')->nullable();

            $table->string('city')->nullable();

            $table->string('state')->nullable();

            $table->string('country')->nullable();

            $table->boolean('is_premium')->default(false);

            $table->string('role')->default('student');

            $table->unsignedBigInteger('added_by')->nullable();

            $table->unsignedBigInteger('center_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
