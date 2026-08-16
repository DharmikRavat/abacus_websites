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
        Schema::create('user_login_logs', function (Blueprint $table) {
            $table->id();
            
            $table->string('user_id');

            $table->string('login_from'); // web, android, ios
        
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
        
            $table->string('os')->nullable();
            $table->string('os_version')->nullable();
        
            $table->string('device')->nullable();
            $table->string('device_type')->nullable();
        
            $table->ipAddress('ip')->nullable();
            $table->longText('user_agent')->nullable();
        
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
        
            $table->timestamp('login_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_login_logs');
    }
};
