<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stoks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('master_locations'); //ambil id dari tabel locations

            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('master_items'); //ambil id dari tabel master items dan kode UM sudah direference pada tabel master items

            $table->integer('saldo'); //stok barang disimpan
            $table->dateTime('transaction_date'); //time date
            $table->dateTime('deleted_at')->nullable(); //menghapus data sementara
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
        Schema::dropIfExists('stoks');
    }
}
