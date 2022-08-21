<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemakaianBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemakaian_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_biaya_id')->constrained();
            $table->foreignId('barang_id')->constrained();
            $table->double('jumlah');
            $table->double('total');
            $table->bigInteger('keterangan_id')->nullable();
            $table->string('keterangan');
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
        Schema::dropIfExists('pemakaian_barangs');
    }
}
