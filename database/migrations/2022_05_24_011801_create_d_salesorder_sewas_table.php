<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDSalesorderSewasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_salesorder_sewas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_salesorder_sewa_id')->constrained();
            $table->foreignId('itemsewa_id')->constrained();
            $table->double('harga_intax');
            $table->integer('lama');
            $table->foreignId('satuan_id')->constrained();
            $table->date('tgl_awal');
            $table->date('tgl_akhir');
            $table->string('status_detail');
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('d_salesorder_sewas');
    }
}
