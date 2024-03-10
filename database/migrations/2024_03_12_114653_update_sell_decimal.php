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
        Schema::table('sell_dtls', function (Blueprint $table) {
            $table->decimal('Rate', 12, 2)->change();
            $table->decimal('SubTotal', 12, 2)->change();
        });

        // Modify 'vendor' table
        Schema::table('customer_list', function (Blueprint $table) {
            $table->decimal('due', 12, 2)->change();
            $table->decimal('profit', 12, 2)->nullable()->change();
            $table->decimal('discount', 12, 2)->nullable()->change();
        });

        // Modify 'purchase_memos' table
        Schema::table('sell_memos', function (Blueprint $table) {
            $table->decimal('PrevDue', 12, 2)->change();
            $table->decimal('TotalBill', 12, 2)->change();
            $table->decimal('Paid', 12, 2)->change();
            $table->decimal('Due', 12, 2)->change();
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
