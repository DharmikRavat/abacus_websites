<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_certifications', function (Blueprint $table) {
            $table->id();

            // Original student reference
            $table->string('student_id');

            // Student snapshot
            $table->string('student_name')->nullable();
            $table->string('parents_name')->nullable();
            $table->string('mobile_no')->nullable();

            // Examination details
            $table->date('exam_date')->nullable();
            $table->string('level')->nullable();
            $table->decimal('score', 8, 2)->nullable();
            $table->string('result')->nullable();

            // Address / receiver details
            $table->text('address')->nullable();
            $table->string('receiver_name')->nullable();
            $table->string('receiver_contact')->nullable();

            // Images
            $table->string('address_image')->nullable();
            $table->string('certificate_image')->nullable();

            // Certificate details
            $table->string('abacus_trainer_name')->nullable();
            $table->date('certificate_date')->nullable();

            // Dispatch details
            $table->date('dispatched_date')->nullable();
            $table->string('dispatched_id')->nullable();
            $table->string('dispatched_link')->nullable();

            // Receiving details
            $table->date('received_date')->nullable();
            $table->text('remark')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_certifications');
    }
};