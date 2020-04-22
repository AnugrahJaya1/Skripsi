<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->increments('id_nilai');
            $table->integer('id_mata_pelajaran')->unsigned();
            $table->foreign('id_mata_pelajaran')->references('id_mata_pelajaran')->on('mata_pelajaran');
            $table->integer('id_mahasiswa')->unsigned();
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('mahasiswa');
            $table->double('101', 5, 2);
            $table->double('102', 5, 2);
            $table->double('111', 5, 2);
            $table->double('112', 5, 2);
            $table->double('AVG', 5, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai');
    }
}
