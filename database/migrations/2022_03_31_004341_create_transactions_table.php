<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bukti');
            $table->dateTime('tgl_transaksi');

            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('master_locations');

            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('master_items');

            $table->integer('qty');
            $table->string('program');
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('transactions');
    }
}
