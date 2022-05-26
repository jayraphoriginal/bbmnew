<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_driver');
            $table->string('tmpt_lahir');
            $table->date('tgl_lahir');
            $table->string('alamat');
            $table->string('pendidikan_terakhir');
            $table->date('tgl_masuk');
            $table->string('agama');
            $table->string('status');
            $table->string('gol_darah');
            $table->string('nobpjstk');
            $table->string('nobpjskes');
            $table->string('notelp');
            $table->string('status_kerja');
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
        Schema::dropIfExists('drivers');
    }
}
