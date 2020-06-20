<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKompetensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetensi', function (Blueprint $table) {
            $table->bigIncrements('id_kompetensi');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('nama_pengembangan');
            $table->string('penyelenggara');
            $table->integer('jp');
            $table->string('kode_pengembangan',4);
            $table->timestamps();
            $table->integer('editor')->nullable();
            $table->foreign('kode_pengembangan')->references('kode_pengembangan')->on('jenis_pengembangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kompetensi');
    }
}
