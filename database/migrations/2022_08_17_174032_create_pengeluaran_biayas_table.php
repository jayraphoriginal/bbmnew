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
            $table->foreignId('supplier_id')->nullable()->constrained();
            $table->foreignId('m_biaya_id')->constrained();
            $table->string('tipe_pembayaran');
            $table->string('mpajak_id')->nullable()->constrained();
            $table->foreignId('rekening_id')->nullable()->constrained();
            $table->double('persen_pajak');
            $table->double('pajak');
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
