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
        Schema::create('expense_lists', function (Blueprint $table) {
            $table->bigIncrements('ExpListID');
            $table->date('Date');
            $table->unsignedBigInteger('ExpID');
            $table->foreign('ExpID')->references('ExpID')->on('expenses');
            $table->decimal('Amount', 8, 2);
            $table->string('Ref')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_lists');
    }
};
