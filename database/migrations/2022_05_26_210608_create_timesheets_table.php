<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('d_so_id');
            $table->date('tanggal');
            $table->foreignId('driver_id')->constrained();
            $table->string('tipe');
            $table->time('jam_awal')->nullable();
            $table->time('jam_akhir')->nullable();
            $table->time('hm_awal')->nullable();
            $table->time('hm_akhir')->nullable();
            $table->integer('istirahat')->nullable();
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
        Schema::dropIfExists('timesheets');
    }
}
