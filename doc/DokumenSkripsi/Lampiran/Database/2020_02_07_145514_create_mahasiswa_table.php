<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->increments('id_mahasiswa');
            $table->string('NPM', 10);
            $table->double('IPK', 3, 2);
            $table->integer('id_jurusan')->unsigned();
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan_sma');
            $table->integer('id_program_studi')->unsigned();
            $table->foreign('id_program_studi')->references('id_program_studi')->on('program_studi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
