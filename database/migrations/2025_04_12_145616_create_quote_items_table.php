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
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('description');
            $table->string('product_source');
            $table->decimal('quantity', 10, 2)->default(1);
            $table->decimal('unit_buy_price', 10, 2);
            $table->decimal('total_buy_price', 10, 2);
            $table->decimal('unit_sell_price', 10, 2);
            $table->decimal('total_sell_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_items');
    }
};
