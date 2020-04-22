<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Jurusan_SMA extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $jurusan = array("Ilmu Pengatahuan Alam", "Ilmu Pengatahuan Sosial");
    public function run(){
        for ($id = 1; $id <= 2; $id++) {
            DB::table("jurusan_sma")->insert([
                "id_jurusan" => $id,
                "nama_jurusan" => $this->jurusan[$id-1]
            ]);
        }
    }
}
