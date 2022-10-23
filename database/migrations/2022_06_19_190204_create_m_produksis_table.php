<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMProduksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_produksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id');
            $table->float('jumlah');
            $table->foreignId('satuan_id')->constrained();
            $table->decimal('hpp',10,4);
            $table->string('keterangan');
            $table->decimal('biaya',10,4);
            $table->foreignId('driver_id')->nullable()->constrained();
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
        Schema::dropIfExists('m_produksis');
    }
}
