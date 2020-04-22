<?php

use Illuminate\Database\Seeder;

class Mata_Pelajaran extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    private $mata_pelajaran = array(
        "Matematika",
        "Bahasa Indonesia",
        "Bahasa Inggris",
        "Fisika",
        "Menggambar",
        "Kewarganegaraan",
        "Kimia"
    );

    public function run()
    {
        for ($i = 0; $i < count($this->mata_pelajaran); $i++) {
            DB::table("mata_pelajaran")->insert([
                "id_mata_pelajaran" => $i + 1,
                "nama_mata_pelajaran" => $this->mata_pelajaran[$i],
            ]);
        }
    }
}
