<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_penjualan_id')->constrained();
            $table->foreignId('barang_id')->constrained();
            $table->double('harga_intax');
            $table->float('jumlah');
            $table->float('sisa');
            $table->foreignId('satuan_id')->constrained();
            $table->string('status_detail');
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
        Schema::dropIfExists('d_penjualans');
    }
}
