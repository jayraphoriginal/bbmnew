<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_customer');
            $table->string('npwp');
            $table->string('alamat');
            $table->string('notelp');
            $table->string('nofax');
            $table->string('nama_pemilik');
            $table->string('jenis_usaha');
            $table->foreignid('coa_id')->nullable()->constrained();
            $table->string('penyetoran_ppn');
            $table->string('penyetoran_pph');
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
        Schema::dropIfExists('customers');
    }
}
