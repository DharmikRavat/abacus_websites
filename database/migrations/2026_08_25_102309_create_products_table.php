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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('item_name');
            $table->string('item_brand')->nullable();
            $table->string('item_type')->nullable();
            $table->text('item_description')->nullable();

            $table->decimal('discount_on_item', 10, 2)->default(0);
            $table->decimal('item_price', 10, 2)->default(0);

            $table->integer('item_qty')->default(0);

            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};