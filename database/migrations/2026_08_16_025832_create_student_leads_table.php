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
        Schema::create('student_leads', function (Blueprint $table) {
            $table->id();
               // Student / Lead details
               $table->string('name')->nullable();
               $table->string('mobile')->nullable();
               $table->string('email')->nullable();
               $table->text('message')->nullable();
   
               // Lead information
               $table->string('region')->nullable();
               $table->date('follow_up_date')->nullable();
   
               // Lead status
               $table->string('response')->nullable();
               $table->string('remark')->nullable();
   
               // Demo & Admission
               $table->string('demo')->nullable();
               $table->string('admission')->nullable();
   
               // Assigned teacher
               $table->string('teacher_name')->nullable();
   
               // Feedback
               $table->text('feedback')->nullable();
               
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_leads');
    }
};
