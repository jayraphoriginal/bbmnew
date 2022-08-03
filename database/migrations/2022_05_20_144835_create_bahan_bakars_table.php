<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanBakarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_bakars', function (Blueprint $table) {
            $table->id();
            $table->string('bahan_bakar');
            $table->decimal('harga_beli',20,2);
            $table->decimal('harga_claim',20,2);
            $table->foreignId('satuan_id')->constrained();
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
        Schema::dropIfExists('bahan_bakars');
    }
}
