<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('balance_sheet', function (Blueprint $table) {
            $table->id();
            $table->decimal('TotalDue', 12, 2);
            $table->decimal('TotalProductPrice', 12, 2);
            $table->decimal('TotalDebt', 12, 2);
            $table->decimal('TotalAccount', 12, 2);
            $table->decimal('TotalUserCash', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        //
    }
};
