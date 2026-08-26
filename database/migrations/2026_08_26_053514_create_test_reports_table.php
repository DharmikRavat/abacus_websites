<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_reports', function (Blueprint $table) {
            $table->id();

            // Student
            $table->unsignedBigInteger('student_id')->nullable();
            $table->string('student_name');
            $table->string('enrollment_id')->nullable();

            // Trainer
            $table->string('trainer_name')->nullable();

            // Test Information
            $table->enum('report_type', ['weekly', 'monthly'])
                  ->default('weekly');

            $table->string('test_name')->nullable();
            $table->string('test_number')->nullable();

            $table->string('level')->nullable();

            // Report Date
            $table->date('report_date')->nullable();

            // Performance
            $table->string('total_time')->nullable();
            $table->integer('total_questions')->default(0);
            $table->integer('correct')->default(0);
            $table->integer('wrong')->default(0);
            $table->integer('skipped')->default(0);

            // Result
            $table->string('result')->nullable();

            // Remarks
            $table->text('remark')->nullable();

            // Homework / Classwork / Test remark
            $table->text('work_remark')->nullable();

            // Parent message
            $table->text('parent_message')->nullable();

            // Status
            $table->enum('status', ['draft', 'published'])
                  ->default('draft');

            $table->timestamps();

            $table->index('student_id');
            $table->index('report_type');
            $table->index('report_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_reports');
    }
};