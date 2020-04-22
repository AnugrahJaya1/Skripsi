<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index($jurusanSMA)
    {
        $idJurusan = 1; //IPA
        if ($jurusanSMA == "IPS") {
            $idJurusan = 2;
        }

        $dataMahasiswa = $this->dataMahasiswa($idJurusan);

        return $dataMahasiswa;
    }

    private function dataMahasiswa($idJurusan)
    {
        $query = Mahasiswa::with('Nilai')->where(['id_jurusan'=> $idJurusan])->get();
        // cuman ambil id_user, NPM, id_mata_pelajaran, nilai, avg, id_program_studi

        return $query;
    }
}
