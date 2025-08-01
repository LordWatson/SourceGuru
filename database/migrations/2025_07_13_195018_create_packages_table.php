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
        // create the packages table
        Schema::create('packages', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('current_version_id')->nullable()->default(1);
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // create the versioning table for packages
        Schema::create('package_versions', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('package_id');
            $table->unsignedInteger('version_number');
            $table->timestamps();
        });

        // add products for a package
        Schema::create('package_products', function (Blueprint $table){
            $table->id();
            $table->foreignId('package_id')->references('id')->on('packages');
            $table->foreignId('product_id')->references('id')->on('products');
            $table->timestamps();
        });

        // products into a version of a package
        Schema::create('package_version_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_version_id')->constrained('package_versions')->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('unit_buy_price', 10, 2)->default(0.00);
            $table->decimal('unit_sell_price', 10, 2)->default(0.00);
            $table->timestamps();
        });

        // now I can add the foreign keys, and the tables have been created
        Schema::table('packages', function (Blueprint $table) {
            $table->foreign('current_version_id')->references('id')->on('package_versions')->nullOnDelete();
        });

        Schema::table('package_versions', function (Blueprint $table) {
            $table->foreign('package_id')->references('id')->on('packages')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
        Schema::dropIfExists('package_products');
        Schema::dropIfExists('package_versions');
        Schema::dropIfExists('package_version_products');
    }
};
