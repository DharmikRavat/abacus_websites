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
        Schema::create('test_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('test_type');               // mock, practice, final
            $table->string('exam_level');              // beginner, intermediate, advanced
            $table->date('schedule_date');
            $table->string('schedule_exam_type');      // online / offline
            $table->string('no_of_questions');
            $table->time('schedule_time');
            $table->string('schedule_password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_schedules');
    }
};
