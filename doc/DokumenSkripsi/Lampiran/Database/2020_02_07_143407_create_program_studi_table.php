<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramStudiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_studi', function (Blueprint $table) {
            $table->increments('id_program_studi');
            $table->string('nama_program_studi', 50);    
            
            $table->integer('id_fakultas')->unsigned();
            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas');

            $table->integer('id_jurusan')->unsigned();
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan_sma');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_studi');
    }
}
