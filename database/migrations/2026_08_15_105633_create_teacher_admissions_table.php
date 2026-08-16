<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_admissions', function (Blueprint $table) {
            $table->id();

            $table->string('teacher_id')->unique();
            $table->string('teacher_name');
            $table->string('mobile_no', 20);

            $table->string('trainer_name')->nullable();
            $table->text('address')->nullable();
            $table->string('region')->nullable();

            $table->date('admission_date')->nullable();

            // Static levels
            $table->decimal('junior_amount', 10, 2)->default(0);

            $table->decimal('level_01_amount', 10, 2)->default(0);
            $table->decimal('level_02_amount', 10, 2)->default(0);
            $table->decimal('level_03_amount', 10, 2)->default(0);
            $table->decimal('level_04_amount', 10, 2)->default(0);
            $table->decimal('level_05_amount', 10, 2)->default(0);
            $table->decimal('level_06_amount', 10, 2)->default(0);
            $table->decimal('level_07_amount', 10, 2)->default(0);
            $table->decimal('level_08_amount', 10, 2)->default(0);
            $table->decimal('level_09_amount', 10, 2)->default(0);
            $table->decimal('level_10_amount', 10, 2)->default(0);

            $table->text('remark')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_admissions');
    }
};