<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserBasedModelController extends Controller
{
    private $pearsonCorrelation;
    private $prediction;
    private $result;

    // mode 0 untuk pengguna
    // mode 1 untuk pengujian 
    public function __construct($mahasiswa, $siswa, $mode = 0)
    {
        // $this->mahasiswa = $mhs;
        // $this->siswa = $siswa;

        // inisialisasi prediction controller
        $this->prediction = new PredictionController();

        if ($mode == 0) {
            // inisialisasi pearson correlation controller
            $this->pearsonCorrelation = new PearsonCorrelationController();
            // menghitung kesamaan atau similaritas
            $pearson = $this->calculateSimilarity($mahasiswa, $siswa);

            // menghitung predikti IPK untuk siswa
            $this->result = $this->calculatePredict($pearson);
        } else if ($mode == 1) {
            $this->pearsonCorrelation = new PearsonCorrelationPengujianController();
        }
    }

    public function calculateSimilarity($mahasiswa, $siswa)
    {
        return $this->pearsonCorrelation->calculatePearson($mahasiswa, $siswa);
    }

    public function calculatePredict($pearson)
    {
        return $this->prediction->calculatePredict($pearson);
    }

    public function getResult()
    {
        return $this->result;
    }
}
