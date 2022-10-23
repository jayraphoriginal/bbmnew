<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutubetonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutubetons', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mutu')->unique();
            $table->float('jumlah');
            $table->ForeignId('satuan_id')->constrained();
            $table->float('berat_jenis');
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
        Schema::dropIfExists('mutubetons');
    }
}
