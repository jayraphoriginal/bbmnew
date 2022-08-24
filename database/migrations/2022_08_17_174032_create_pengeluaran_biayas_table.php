<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranBiayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran_biayas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->nullable();
            $table->foreignId('m_biaya_id')->constrained();
            $table->string('tipe_pembayaran');
            $table->string('ppn_id')->nullable();
            $table->string('pajaklain_id')->nullable();
            $table->foreignId('rekening_id')->nullable();
            $table->double('persen_ppn');
            $table->double('persen_pajaklain');
            $table->double('ppn');
            $table->double('total');
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('pengeluaran_biayas');
    }
}
