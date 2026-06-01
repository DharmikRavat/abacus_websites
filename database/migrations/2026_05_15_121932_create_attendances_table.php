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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');

            // teacher/admin who marked attendance
            $table->unsignedBigInteger('mark_by_id')->nullable();

            $table->date('attendance_date');

            /*
                P = Present
                A = Absent
                H = Holiday
                E = Extra Class
                L = Leave
            */

            $table->enum('status', ['P', 'A', 'H', 'E', 'L'])
                  ->default('P');

            $table->text('remark')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
