<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpGajiDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_gaji_drivers', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->integer('periode');
            $table->string('nopol');
            $table->string('nama_driver');
            $table->date('tanggal_ticket');
            $table->string('nama_customer');
            $table->string('lokasi');
            $table->decimal('jarak',10,2);
            $table->decimal('pemakaian_bbm',10,2);
            $table->decimal('lembur',10,2);
            $table->decimal('gaji', 10,2);
            $table->decimal('pengisian_bbm',10,2);
            $table->decimal('loading',10,2);
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
        Schema::dropIfExists('tmp_gaji_drivers');
    }
}
