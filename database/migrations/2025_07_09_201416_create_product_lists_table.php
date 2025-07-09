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
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('product_sub_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_type_id')->references('id')->on('product_types');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('product_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('active');
            $table->string('source')->nullable();
            $table->foreignId('product_type_id')->references('id')->on('product_types');
            $table->foreignId('product_sub_type_id')->references('id')->on('product_sub_types');
            $table->decimal('unit_buy_price', 10, 2)->default(0.00);
            $table->decimal('unit_sell_price', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_lists');
        Schema::dropIfExists('product_types');
        Schema::dropIfExists('product_sub_types');
    }
};
