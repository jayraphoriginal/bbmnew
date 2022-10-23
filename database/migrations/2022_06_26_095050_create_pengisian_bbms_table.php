<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengisianBbmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengisian_bbms', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengisian');
            $table->foreignId('supplier_id')->constrained();
            $table->foreignId('kendaraan_id')->constrained();
            $table->foreignId('driver_id')->constrained();
            $table->foreignId('bahan_bakar_id')->constrained();
            $table->decimal('jumlah',10,2);
            $table->decimal('harga',10,2);
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
        Schema::dropIfExists('pengisian_bbms');
    }
}
