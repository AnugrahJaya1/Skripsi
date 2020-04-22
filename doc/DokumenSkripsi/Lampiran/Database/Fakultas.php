<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Fakultas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $fakultas = array(
        "Fakultas Ekonomi", "Fakultas Hukum", "Fakultas Ilmu Sosial dan Ilmu Politik",
        "Fakultas Teknik", "Fakultas Falsafah dan Peradaban", "Fakultas Teknik Industri",
        "Fakultas Teknologi Informasi dan Sains"
    );

    public function run(){
        for ($id = 1; $id <= 7; $id++) {
            DB::table("fakultas")->insert([
                "id_fakultas" => $id,
                "nama_fakultas" => $this->fakultas[$id-1]
            ]);
        }
    }
}
