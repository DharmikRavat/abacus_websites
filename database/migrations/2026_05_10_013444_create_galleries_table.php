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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();

            // 1 = Image, 2 = Video
            $table->tinyInteger('media_type')->default(1);

            $table->string('media')->nullable();

            $table->text('youtube_link')->nullable();

            $table->boolean('is_active')->default(1);

            $table->boolean('is_dashboard')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
