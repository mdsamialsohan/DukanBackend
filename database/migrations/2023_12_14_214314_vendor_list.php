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
        Schema::create('vendor', function (Blueprint $table) {
            $table->id('VendorID');
            $table->string('VendorName');
            $table->text('VendorAddress');
            $table->decimal('Debt', 10, 2); // Assuming debt is a decimal with 10 digits in total, 2 after the decimal point
            $table->string('VendorMobile');
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor');
    }
};
