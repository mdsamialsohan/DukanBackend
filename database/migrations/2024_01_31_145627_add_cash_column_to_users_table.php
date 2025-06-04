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
        if(!Schema::hasColumn('users','cash'))
        {
            Schema::table('users', function (Blueprint $table) {
                $table->decimal('Cash', 10, 2)->default(0);
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasColumn('users','cash')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('Cash');
            });
        }
    }
};
