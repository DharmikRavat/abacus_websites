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
        Schema::create('student_certificates', function (Blueprint $table) {
            $table->id();

              // Unique Certificate ID
              $table->string('certificate_unique_id')->unique();

              // Certificate Title
              $table->string('title');
  
              // Certificate File Path
              $table->string('file');
  
              // Student Enrollment ID
              $table->string('student_enrollment_id');
  
              // Admin/Teacher User ID
              $table->string('added_by');
              $table->string('dummy');
  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_certificates');
    }
};
