<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDProduksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_produksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produksi_id')->constrained()->onDelete('restrict');
            $table->foreignId('barang_id')->constrained()->onDelete('restrict');
            $table->float('jumlah');
            $table->foreignId('satuan_id')->constrained()->onDelete('restrict');
            $table->decimal('hpp',20,4);
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
        Schema::dropIfExists('d_produksis');
    }
}
