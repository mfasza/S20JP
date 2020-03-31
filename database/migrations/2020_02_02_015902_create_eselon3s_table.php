<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEselon3sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eselon3', function (Blueprint $table) {
            $table->bigIncrements('kode_eselon3');
            $table->string('unit_eselon3');
            $table->bigInteger('kode_eselon2')->unsigned();
            $table->foreign('kode_eselon2')->references('kode_eselon2')->on('eselon2')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eselon3');
    }
}
