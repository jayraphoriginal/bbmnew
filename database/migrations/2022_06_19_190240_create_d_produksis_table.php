<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDProduksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_produksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_produksi_id')->constrained();
            $table->foreignId('barang_id')->constrained();
            $table->float('jumlah');
            $table->foreignId('satuan_id')->constrained();
            $table->decimal('hpp',20,4);
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
        Schema::dropIfExists('d_produksis');
    }
}
