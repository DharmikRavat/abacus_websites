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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();

            $table->string('profile')->nullable();

            $table->string('slug_id')->nullable();

            $table->string('email')->nullable()->unique();

            $table->timestamp('email_verified_at')->nullable();

            $table->string('password')->nullable();

            $table->integer('type')->default(0);

            $table->text('permissions')->nullable();

            $table->boolean('status')->default(true);

            $table->text('fcm_id')->nullable();

            $table->rememberToken();

            $table->string('role')->default('teacher');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
