<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('noinvoice');
            $table->string('tipe_so');
            $table->BigInteger('so_id');
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('rekening_id')->constrained();
            $table->date('tgl_pembayaran')->nullable();
            $table->string('tipe');
            $table->double('total');
            $table->double('sisa_invoice');
            $table->double('dpp');
            $table->double('ppn');
            $table->string('status');
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
        Schema::dropIfExists('invoices');
    }
}
