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
        Schema::create('task_param_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('order_fulfillment_tasks')->cascadeOnDelete(); // the task we're getting the param FOR
            $table->string('param_key'); // "ip_address"
            $table->foreignId('source_task_id')->constrained('order_fulfillment_tasks')->cascadeOnDelete(); // the task we're getting the param FROM
            $table->string('source_output_key'); // "ip"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_param_mappings');
    }
};
