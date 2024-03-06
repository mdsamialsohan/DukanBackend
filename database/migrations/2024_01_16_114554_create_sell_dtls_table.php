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
        Schema::create('sell_dtls', function (Blueprint $table) {
            $table->id('SellDtID');
            $table->unsignedBigInteger('ProductID');
            $table->foreign('ProductID')->references('ProductID')->on('products');
            $table->unsignedBigInteger('SellMemoID');
            $table->foreign('SellMemoID')->references('SellMemoID')->on('sell_memos');
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
        Schema::dropIfExists('sell_dtls');
    }
};
