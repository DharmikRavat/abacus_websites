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
        Schema::create('franchise_pages', function (Blueprint $table) {
            $table->id();

            // Top Section
            $table->string('title')->nullable();
            $table->longText('training_description')->nullable();

            // Advantages Section
            $table->string('advantages_title')->nullable();
            $table->longText('advantages_description')->nullable();
            $table->string('advantages_image')->nullable();

            // Why Join Us
            $table->string('why_join_title')->nullable();
            $table->longText('why_join_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('franchise_pages');
    }
};
