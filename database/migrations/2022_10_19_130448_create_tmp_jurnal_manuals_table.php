<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpJurnalManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_jurnal_manuals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coa_id')->constrained()->onDelete('cascade');
            $table->double('money');
            $table->double('money');
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
        Schema::dropIfExists('tmp_jurnal_manuals');
    }
}
