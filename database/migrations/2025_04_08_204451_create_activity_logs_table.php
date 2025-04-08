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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('model');
            $table->unsignedBigInteger('model_id');
            $table->string('event');
            $table->string('message')->nullable();
            $table->integer('status_code')->nullable();
            $table->string('method');
            $table->string('path');
            $table->string('user_agent');
            $table->ipAddress('ip_address');
            $table->json('original')->nullable();
            $table->json('changes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
