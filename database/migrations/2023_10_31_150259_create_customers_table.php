<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('customer_list', function (Blueprint $table) {
            $table->bigIncrements('c_id')->unique();
            $table->string('name');
            $table->string('mobile');
            $table->text('address');
            $table->decimal('due', 8, 2);
            $table->string('national_id')->nullable(); // Assuming national_id is a string
            $table->decimal('profit', 8, 2)->nullable(); // Assuming profit is a decimal
            $table->decimal('discount', 8, 2)->nullable(); // Assuming discount is an integer
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_list');
    }
};
