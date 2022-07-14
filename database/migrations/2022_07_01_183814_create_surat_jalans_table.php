<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratJalansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_jalans', function (Blueprint $table) {
            $table->id();
            $table->string('nosuratjalan');
            $table->date('tgl_pengiriman');
            $table->foreignId('m_penjualan_id')->constrained()->onDelete('restrict');
            $table->foreignId('rate_id')->constrained()->onDelete('restrict');
            $table->foreignid('customer_id')->constrained()->onDelete('restrict');
            $table->string('driver');
            $table->string('nopol');
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
        Schema::dropIfExists('surat_jalans');
    }
}
