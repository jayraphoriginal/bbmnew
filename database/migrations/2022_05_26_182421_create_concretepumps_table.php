<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcretepumpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concretepumps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_salesorder_id')->constrained();
            $table->foreignId('kendaraan_id')->constrained();
            $table->foreignId('driver_id')->constrained();
            $table->foreignId('jarak_tempuh_id')->constrained();
            $table->foreignId('rate_id')->constrained();
            $table->double('harga_sewa');
            $table->string('keterangan')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('concretepumps');
    }
}
