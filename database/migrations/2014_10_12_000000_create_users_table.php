<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('username')->unique()->primary()->collation('latin1_general_cs');
            $table->bigInteger('kode_satker')->nullable();
            $table->string('email')->default('null')->collation('latin1_general_cs');
            $table->string('password')->collation('latin1_general_cs');
            $table->string('role', 10)->collation('latin1_general_cs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
