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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained();
            $table->foreignId('created_by')->references('id')->on('users');
            $table->longText('url')->nullable();
            $table->string('signed_name')->nullable();
            $table->string('signed_email')->nullable();
            $table->string('signed_ip')->nullable();
            $table->string('signed_user_agent')->nullable();
            $table->date('signed_date_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
