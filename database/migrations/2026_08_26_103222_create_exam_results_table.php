<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();

            // Student reference
            $table->string('student_id');

            // Score / exam attempt reference
            $table->foreignId('score_id')
                ->constrained('scores')
                ->cascadeOnDelete();

            // Result declaration
            $table->string('result')->nullable();
            $table->string('remark')->nullable();

            // Who declared the result
            $table->string('declared_by');

            $table->timestamp('declared_at')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};