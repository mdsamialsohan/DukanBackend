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
        Schema::create('purchase_memos', function (Blueprint $table) {
            $table->id('PurMemoID');
            $table->date('Date');
            $table->unsignedBigInteger('VendorID');
            $table->foreign('VendorID')->references('VendorID')->on('vendor');
            $table->decimal('PrevDebt', 8, 2);
            $table->decimal('TotalBill', 8, 2);
            $table->decimal('Paid', 8, 2);
            $table->decimal('Debt', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_memos');
    }
};
