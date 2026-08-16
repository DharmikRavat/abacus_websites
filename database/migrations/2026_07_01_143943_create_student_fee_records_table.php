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
        Schema::create('student_fee_records', function (Blueprint $table) {
            $table->id();

            $table->string('student_enrollment_id');

            $table->string('financial_year');

            $table->decimal('april', 10, 2)->default(0);
            $table->decimal('may', 10, 2)->default(0);
            $table->decimal('june', 10, 2)->default(0);
            $table->decimal('july', 10, 2)->default(0);
            $table->decimal('august', 10, 2)->default(0);
            $table->decimal('september', 10, 2)->default(0);
            $table->decimal('october', 10, 2)->default(0);
            $table->decimal('november', 10, 2)->default(0);
            $table->decimal('december', 10, 2)->default(0);
            $table->decimal('january', 10, 2)->default(0);
            $table->decimal('february', 10, 2)->default(0);
            $table->decimal('march', 10, 2)->default(0);

            $table->decimal('total_amount', 10, 2)->default(0);

            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_fee_records');
    }
};
