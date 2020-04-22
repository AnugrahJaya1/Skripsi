<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Program_Studi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $id_fakultas = array(1, 2, 3, 4, 5, 6, 7);
    private $count = array(3, 1, 3, 2, 1, 3, 3);
    private $program_studi = array(
        array("Ekonomi Pembangunan", "Manajemen", "Akuntansi"),
        array("Ilmu Hukum"),
        array("Ilmu Administrasi Publik", "Ilmu Administrasi Bisnis", "Ilmu Hubungan Internasional"),
        array("Teknik Sipil", "Arsitektur"),
        array("Ilmu Filsafat"),
        array("Teknik Industri", "Teknik Kimia", "Teknik Elektro"),
        array("Matematika", "Fisika", "Teknik Informatika")
    );

    public function run()
    {
        for ($i = 1; $i <= 7; $i++) {

            $id_f = $this->id_fakultas[$i - 1];
            $id_j = 1;

            // untuk id program studi/kode
            for ($j = 1; $j <= $this->count[$i - 1]; $j++) {
                // jika fakultas hukum
                if ($this->id_fakultas[$i - 1] == 2) {
                    $id_program_studi = $id_f * 100;
                } else {
                    $id_program_studi = $id_f * 100 + ($j * 10);
                }
                if ($id_f == 1 || $id_f == 2 || $id_f == 3 || $id_f == 5) {
                    $id_j = 2;
                }
                DB::table("program_studi")->insert([
                    "id_program_studi" => $id_program_studi,
                    "nama_program_studi" => $this->program_studi[$i - 1][$j - 1],
                    "id_fakultas" => $id_f,
                    "id_jurusan" => $id_j
                ]);
            }
        }
    }
}
