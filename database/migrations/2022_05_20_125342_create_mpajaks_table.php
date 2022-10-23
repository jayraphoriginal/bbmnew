<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpajaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpajaks', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_pajak');
            $table->float('persen');
            $table->unsignedBigInteger('coa_id_debet');
            $table->unsignedBigInteger('coa_id_kredit');
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
        Schema::dropIfExists('mpajaks');
    }
}
