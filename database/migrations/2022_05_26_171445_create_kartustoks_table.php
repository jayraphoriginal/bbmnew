<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKartustoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kartustoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained();
            $table->string('tipe');
            $table->bigInteger('trans_id');
            $table->float('increase');
            $table->float('decrease');
            $table->decimal('harga_debet',20,2);
            $table->decimal('harga_kredit',20,2);
            $table->float('qty');
            $table->decimal('modal',20,2);
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
        Schema::dropIfExists('kartustoks');
    }
}
