<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMPurchaseordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_purchaseorders', function (Blueprint $table) {
            $table->id();
            $table->string('nopo');
            $table->string('nofaktur');
            $table->string('tgl_masuk');
            $table->string('jatuh_tempo');
            $table->foreignId('supplier_id')->constrained();
            $table->string('tipe');
            $table->double('dpp');
            $table->double('ppn');
            $table->double('total');
            $table->string('pembebanan');
            $table->biginteger('jenis_pembebanan')->nullable();
            $table->biginteger('beban_id')->nullable();
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
        Schema::dropIfExists('m_purchaseorders');
    }
}
