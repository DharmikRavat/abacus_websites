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
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->string('country_name')->nullable();

            $table->string('state_name')->nullable();

            $table->string('district_name')->nullable();

            $table->string('center_name');

            $table->text('center_address')->nullable();

            $table->string('center_contact')->nullable();

            $table->unsignedBigInteger('assigned_teacher_id')->nullable();

            $table->string('assigned_teacher_name')->nullable(); 

            $table->text('assigned_teacher_about')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};
