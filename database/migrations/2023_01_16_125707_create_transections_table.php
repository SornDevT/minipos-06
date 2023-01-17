<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // "tran_id","product_id","tran_type","amount","tran_detail","price"
        Schema::create('transections', function (Blueprint $table) {
            $table->id();
            $table->string('tran_id');
            $table->string('product_id');
            $table->string('tran_type');
            $table->integer('amount');
            $table->string('tran_detail')->nullable();
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transections');
    }
}
