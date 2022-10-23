<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSalesordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_salesorders', function (Blueprint $table) {
            $table->id();
            $table->string('noso');
            $table->date('tgl_so');
            $table->string('nopo')->nullable();
            $table->string('marketing');
            $table->string('pembayaran');
            $table->string('jenis_pembayaran');
            $table->date('jatuh_tempo');
            $table->foreignId('customer_id')->constrained();
            $table->string('status_so');
            $table->float('pajak');
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
        Schema::dropIfExists('m_salesorders');
    }
}
