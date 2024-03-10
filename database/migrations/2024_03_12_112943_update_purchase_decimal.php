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
        // Modify 'purchase_dtls' table
        Schema::table('purchase_dtls', function (Blueprint $table) {
            $table->decimal('Rate', 12, 2)->change();
            $table->decimal('SubTotal', 12, 2)->change();
        });

        // Modify 'vendor' table
        Schema::table('vendor', function (Blueprint $table) {
            $table->decimal('Debt', 12, 2)->change();
        });

        // Modify 'purchase_memos' table
        Schema::table('purchase_memos', function (Blueprint $table) {
            $table->decimal('PrevDebt', 12, 2)->change();
            $table->decimal('TotalBill', 12, 2)->change();
            $table->decimal('Paid', 12, 2)->change();
            $table->decimal('Debt', 12, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
