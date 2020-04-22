<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PearsonCorrelationController extends Controller
{
    
    // menghitung kemiripan dengan perason
    // $mahasiswa -> seluruh mahasiswa sesuai dengan jurusan SMA
    // $siswa -> 
    public function calculatePearson($mahasiswa, $siswa)
    {
        $res = array();
        foreach ($mahasiswa as $mhs) {
            $covariance = $this->calculateCovariance($mhs, $siswa);
            $sd = $this->calculateStandarDeviation($mhs, $siswa);
            $sdMhs = $sd[0]; // standar deviasi untuk mahasiswa
            $sdSiswa = $sd[1]; // standar deviasi untuk siswa

            $idProdi = $mhs['id_program_studi'];
            $IPK = $mhs['IPK'];

            $sim = $covariance / ($sdMhs * $sdSiswa);
            // atur threshold
            if ($sim > 0) {
                // inisialisai array agar tidak null
                $res[$mhs['id_mahasiswa']] = array();
                array_push($res[$mhs['id_mahasiswa']], $sim, $idProdi, $IPK);
            }
        }
        return $res;
    }

    // untuk menghitung kovariansi satu mahasiswa
    // dengan satu siswa
    private function calculateCovariance($mhs, $siswa)
    {
        $res = 0;
        // nilai 1 mhs
        $nilaiMhs = $mhs['nilai'];
        $nilaiSiswa = $siswa['nilai'];
        // looping sebanyak nilai
        foreach ($nilaiSiswa as $nSiswa) {
            $idMP = $nSiswa['id_mata_pelajaran'];
            // looping sebanyak nilai mahasiswa pada index
            foreach ($nilaiMhs as $nMhs) {
                // hanya menghitung mata pelajaran yang beririsan
                if ($idMP == $nMhs['id_mata_pelajaran']) {
                    for ($i = 0; $i < 4; $i++) {
                        //mahasiswa * siswa
                        $res += ($nMhs[$i] - $nMhs["AVG"]) * ($nSiswa[$i] - $nSiswa["AVG"]);
                    }
                } else if ($idMP < $nMhs['id_mata_pelajaran']) {
                    break;
                }
            }
        }
        return $res;
    }

    // mengitung standar deviasi untuk satu mahasiswa
    // dan satu siswa
    private function calculateStandarDeviation($mhs, $siswa)
    {
        $res = array();

        $sdMhs = 0;
        $sdSiswa = 0;
        // nilai 1 mhs
        $nilaiMhs = $mhs['nilai'];
        $nilaiSiswa = $siswa['nilai'];
        // looping sebanyak nilai
        foreach ($nilaiSiswa as $nSiswa) {
            $idMP = $nSiswa['id_mata_pelajaran'];
            // looping sebanyak nilai mahasiswa pada index
            foreach ($nilaiMhs as $nMhs) {
                // hanya menghitung mata pelajaran yang beririsan
                if ($idMP == $nMhs['id_mata_pelajaran']) {
                    for ($i = 0; $i < 4; $i++) {
                        $sdMhs += pow($nMhs[$i] - $nMhs['AVG'], 2);
                        $sdSiswa += pow($nSiswa[$i] - $nSiswa["AVG"], 2);
                    }
                } else if ($idMP < $nMhs['id_mata_pelajaran']) {
                    break;
                }
            }
        }
        array_push($res, sqrt($sdMhs), sqrt($sdSiswa));

        return $res;
    }
}
