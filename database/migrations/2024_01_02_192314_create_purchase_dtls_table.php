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
        Schema::create('purchase_dtls', function (Blueprint $table) {
            $table->id('PurDtID');
            $table->unsignedBigInteger('ProductID');
            $table->foreign('ProductID')->references('ProductID')->on('products');
            $table->unsignedBigInteger('PurMemoID');
            $table->foreign('PurMemoID')->references('PurMemoID')->on('purchase_memos');
            $table->integer('Quantity');
            $table->decimal('Rate', 8, 2);
            $table->decimal('SubTotal', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_dtls');
    }
};
