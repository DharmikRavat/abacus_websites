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
        Schema::create('certifications', function (Blueprint $table) {
            
            $table->id();

            // Basic Details
            $table->string('trainer_name')->nullable();
            $table->date('certificate_date')->nullable();
            $table->string('level')->nullable();

            // Student Details
            $table->string('student_name')->nullable();
            $table->string('parents_name')->nullable();
            $table->string('mobile_no')->nullable();
            $table->date('exam_date')->nullable();

            // Result Details
            $table->integer('score')->nullable();
            $table->string('result')->nullable();

            // Address
            $table->text('address')->nullable();
            $table->string('receiver_contact')->nullable();

            // Images
            $table->string('address_image')->nullable();
            $table->string('certificate_image')->nullable();

            // Dispatch Details
            $table->date('dispatch_date')->nullable();
            $table->string('dispatch_id')->nullable();

            // Receive Details
            $table->date('received_date')->nullable();
            $table->text('remark')->nullable();

            // Download Type
            $table->string('download_type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
