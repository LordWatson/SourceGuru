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
        Schema::create('product_step_dependencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_fulfillment_step_id')->constrained('product_fulfillment_steps')->cascadeOnDelete();
            $table->foreignId('depends_on_step_id')->constrained('product_fulfillment_steps')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_step_dependencies');
    }
};
