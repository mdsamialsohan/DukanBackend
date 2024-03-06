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
            $table->id('ProductID');
            $table->unsignedBigInteger('BrandID')->nullable();
            $table->foreign('BrandID')->references('BrandID')->on('product_brands');
            $table->unsignedBigInteger('ProductCatID')->nullable();
            $table->foreign('ProductCatID')->references('ProductCatID')->on('product_cat');
            $table->unsignedBigInteger('UnitID')->nullable();
            $table->foreign('UnitID')->references('UnitID')->on('product_units');
            $table->integer('ProductUnit')->nullable();
            $table->decimal('ExpPerUnit', 8, 2)->nullable();
            $table->decimal('Rate', 8, 2)->nullable();
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
