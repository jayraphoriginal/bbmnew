<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKendaraansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('nopol');
            $table->string('nama_pemilik');
            $table->string('alamat');
            $table->string('tipe');
            $table->string('model');
            $table->string('tahun_pembuatan');
            $table->string('warnakb');
            $table->date('berlaku_sampai');
            $table->date('berlaku_kir');
            $table->date('tgl_perolehan');
            $table->date('siu');
            $table->integer('muatan');
            $table->float('loading');
            $table->foreignId('driver_id')->constrained();
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
        Schema::dropIfExists('kendaraans');
    }
}
