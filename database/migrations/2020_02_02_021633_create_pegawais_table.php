<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->bigIncrements('nip');
            $table->string('nama');
            $table->bigInteger('kode_eselon2')->unsigned();
            $table->bigInteger('kode_eselon3')->unsigned()->nullable();
            $table->foreign('kode_eselon2')->references('kode_eselon2')->on('eselon2')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kode_eselon3')->references('kode_eselon3')->on('eselon3')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
}
