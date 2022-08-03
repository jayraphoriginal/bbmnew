<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('d_salesorder_id')->constrained();
            $table->string('noticket');
            $table->bigInteger('kendaraan_id');
            $table->bigInteger('driver_id');
            $table->datetime('jam_ticket')->nullable();
            $table->float('jumlah');
            $table->foreignId('satuan_id')->constrained();
            $table->float('loading');
            $table->decimal('tambahan_biaya',20,2);
            $table->decimal('lembur',10,2);
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
        Schema::dropIfExists('tickets');
    }
}
