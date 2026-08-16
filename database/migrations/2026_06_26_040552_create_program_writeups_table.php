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
        Schema::create('program_writeups', function (Blueprint $table) {
            $table->id();
            $table->longText('paragraph_1')->nullable();
            $table->longText('paragraph_2')->nullable();

            // Store bullet points as JSON
            $table->json('bullet_points')->nullable();

            $table->string('footer_title')->nullable();
            $table->string('footer_subtitle')->nullable();
            $table->string('footer_image')->nullable(); // Image path
            $table->longText('footer_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_writeups');
    }
};
