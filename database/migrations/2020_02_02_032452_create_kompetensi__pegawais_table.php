<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKompetensiPegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetensi_pegawai', function (Blueprint $table) {
            $table->bigInteger('nip')->unsigned();
            $table->bigInteger('id_kompetensi')->unsigned();
            $table->timestamps();
            $table->integer('editor')->nullable();
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_kompetensi')->references('id_kompetensi')->on('kompetensi')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['nip', 'id_kompetensi']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kompetensi_pegawai');
    }
}
