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
        Schema::create('order_fulfillment_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quote_item_id')->constrained('quote_items')->cascadeOnDelete();
            $table->foreignId('fulfillment_step_id')->constrained()->cascadeOnDelete();
            $table->integer('step_order');
            $table->string('status')->default('blocked'); // 'pending', 'in_progress', 'success', 'failed', 'blocked'
            $table->json('params')->nullable();
            $table->json('output')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_fulfillment_tasks');
    }
};
