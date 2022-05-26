<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDSalesordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_salesorders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_salesorder_id')->constrained()->ondelete('cascade');
            $table->foreignId('rate_id')->constrained()->ondelete('cascade');
            $table->foreignId('jarak_tempuh_id')->constrained()->ondelete('cascade');
            $table->foreignId('mutubeton_id');
            $table->decimal('harga_intax',20,2);
            $table->float('jumlah');
            $table->float('sisa');
            $table->foreignId('satuan_id')->constrained()->ondelete('cascade');
            $table->date('tgl_awal');
            $table->date('tgl_akhir');
            $table->string('status_detail');
            $table->foreignId('user_id')->constrained()->ondelete('cascade');
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
        Schema::dropIfExists('d_salesorders');
    }
}
