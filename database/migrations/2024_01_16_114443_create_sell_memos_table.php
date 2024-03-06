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
        Schema::create('sell_memos', function (Blueprint $table) {
            $table->id('SellMemoID');
            $table->date('Date');
            $table->unsignedBigInteger('c_id');
            $table->foreign('c_id')->references('c_id')->on('customer_list');
            $table->decimal('PrevDue', 8, 2);
            $table->decimal('TotalBill', 8, 2);
            $table->decimal('Paid', 8, 2);
            $table->decimal('Due', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_memos');
    }
};
