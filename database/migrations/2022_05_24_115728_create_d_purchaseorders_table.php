<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDPurchaseordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_purchaseorders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_purchaseorder_id')->constrained();
            $table->foreignId('barang_id')->constrained();
            $table->float('jumlah');
            $table->foreignId('satuan_id')->constrained();
            $table->double('harga');
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
        Schema::dropIfExists('d_purchaseorders');
    }
}
