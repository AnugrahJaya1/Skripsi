<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PredictionController extends Controller
{
    private $programStudi;
    private $fakultas;

    public function __construct()
    {
        $this->programStudi = new ProgramStudiController();
        $this->fakultas = new FakultasController();
    }

    public function calculatePredict($pearson)
    {
        $res = array();

        // a = Sigma(sim * IPK)
        $a = 0;
        // b = Sigma(sim)
        $b = 0;
        // pred = a/b
        // id_mhs -> sim, id_prodi, IPK, avgMhs, avgSiswa 
        foreach ($pearson as $id_mhs => $value) {
            $a += $value[0] * $value[2];
            $b += $value[0];

            $next = next($pearson);

            if ($next != null) {
                // program studi mhs sekarang berbeda dengan mhs selanjutnya
                if ($value[1] != $next[1]) {
                    $res = $this->insertData($res, $a, $b, $value[1]);

                    $a = 0;
                    $b = 0;
                }
            } else if ($next == null) {
                $res = $this->insertData($res, $a, $b, $value[1]);
            }
        }

        // // penampung untuk nilai prediksi IPK
        $score = array_column($res, 0);
        // sort berdasarkan nilai prediksi ipk terbesar
        array_multisort($score, SORT_DESC, $res);

        return $res;
    }

    private function insertData($res, $a, $b, $idProdi)
    {
        $pred = $a / $b;
        $namaFakultas = $this->fakultas->getNamaFakultas($idProdi);
        $namaProdi = $this->programStudi->getNamaProgramStudi($idProdi);
        $res[$idProdi] = array();
        // dibalik
        array_push($res[$idProdi], $pred, $namaFakultas, $namaProdi);

        return $res;
    }
}
