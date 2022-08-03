<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained();
            $table->foreignId('d_purchaseorder_id')->nullable()->constrained();
            $table->date('tgl_masuk');
            $table->float('jumlah_masuk');
            $table->float('jumlah');
            $table->double('hpp');
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
        Schema::dropIfExists('d_barangs');
    }
}
