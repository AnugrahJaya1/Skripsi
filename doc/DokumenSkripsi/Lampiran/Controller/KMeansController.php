<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KMeansController extends Controller
{
    public $currCentroid;
    private $prevCentroid;
    private $k;
    public $cluster;
    private $mahasiswa;
    private $J0, $J1;

    function __construct($k, $dataMahasiswa)
    {
        $this->k = $k;
        $this->mahasiswa = $dataMahasiswa;
        $this->inisialisasiCluster();
        $this->currCentroid = array();

        // J0 = inisialisasi jarak total dari objek ke centroid-nya
        $this->J0 = 100;

        $this->pilihCentroid();

        $this->hitungJarakMhs();

        $status = true;
        $idx = 0;
        while ($status) {
            $this->hitungCentroidBaru();
            $idx++;
            
            $status = $this->cekBatas();
            $this->hitungJarakMhs();
        }
    }

    private function inisialisasiCluster()
    {
        $this->cluster = array();
        // inisialisasi untuk res anggota cluster
        for ($i = 0; $i < $this->k; $i++) {
            $this->cluster[$i] = array();
        }
    }

    // fungsi untuk memilih secara acak mahasiswa mana
    // yang akan dijadikan centroid
    private function pilihCentroid()
    {
        $i = 0;
        while ($i < $this->k) {
            $key = rand(0, 1739);
            if (array_key_exists($key, $this->mahasiswa)) {
                // cek apakah ada key(idx) pada currCentroid
                if (!array_key_exists($key, $this->currCentroid)) {
                    array_push($this->currCentroid, $this->mahasiswa[$key]);
                    $i++;
                }
            }
        }
    }

    // fungsi untuk menghitung jarak untuk untuk 
    // mata pelajaran mtk (1) dan ing (3)
    private function hitungJarakMhs()
    {
        $this->J1 = 0;
        // looping sebanyak mahasiswa
        foreach ($this->mahasiswa as $keyMhs => $valueMhs) {
            // array sementara untuk menentukan masuk cluster mana
            $tempCluster = array();
            // array yang berisikan nilai satu mahasiswa
            $nilaiMhs = $valueMhs['nilai'];
            // looping sebanyak nilai mahasiswa
            foreach ($nilaiMhs as $keyNilaiMhs => $valueNilaiMhs) {
                // array untuk menampung jarak
                $arrJarak = array();
                // looping sebanyak centroid
                foreach ($this->currCentroid as $keyCen => $valuCen) {
                    // penampung jarak
                    $jarak = 0;
                    // array yang berisikan nilai pada centroid
                    $nilaiCen = $valuCen['nilai'];
                    // looping sebanyak nilai centroid
                    foreach ($nilaiCen as $keyNilaiCen => $valueNilaiCen) {
                        // cek apakah pada mata pelajaran yang sama atau tidak
                        if (
                            ($valueNilaiMhs['id_mata_pelajaran'] == 1 && $valueNilaiCen['id_mata_pelajaran'] == 1)
                            ||
                            ($valueNilaiMhs['id_mata_pelajaran'] == 3 && $valueNilaiCen['id_mata_pelajaran'] == 3)
                        ) {
                            // hitung jarak dengan euclidian distance
                            $jarak = $this->euclidianceDistance($valueNilaiMhs, $valueNilaiCen);
                        } else if ($valueNilaiMhs['id_mata_pelajaran'] < $valueNilaiCen['id_mata_pelajaran']) {
                            break;
                        }
                    }
                    // memasukkan jarak antara mhs(nilai) dengan centroid(nilai)
                    // index 0 nilai dengan mata pelajaran mtk (1)
                    // index 1 nilai dengan mata pelajaran ing (3)
                    array_push($arrJarak, $jarak);
                }
                // cek apakah tempCluster kosong
                if (empty($tempCluster)) {
                    array_push($tempCluster, $arrJarak);
                } else {
                    // menghitung jarak sebenarnya
                    // dari dua nilai
                    for ($i = 0; $i < $this->k; $i++) {
                        $tempCluster[0][$i] += $arrJarak[$i];
                        $tempCluster[0][$i] = sqrt($tempCluster[0][$i]);
                    }
                }
            }
            // menentukan mhs masuk pada cluster mana
            $c = array_keys($tempCluster[0], min($tempCluster[0]))[0];

            $this->J1 += $tempCluster[0][$c];

            array_push($tempCluster[0], $c, $valueMhs['id_mahasiswa']);

            // mengubah key index array
            $tempCluster[0]['id_mahasiswa'] = $tempCluster[0][$this->k + 1];
            unset($tempCluster[0][$this->k + 1]);

            // memasukkan mhs ke array hasil
            array_push($this->cluster[$c], $valueMhs);
        }
    }

    public function hitungJarakSiswa($siswa)
    {
        $nilaiSiswa = $siswa['nilai'];
        $tempCluster = array();
        // looping untuk nilai siswa
        foreach ($nilaiSiswa as $keyNilaiSiswa => $valueNilaiSiswa) {
            $arrJarak = array();
            // looping sebanyak centroid
            foreach ($this->currCentroid as $keyCen => $valuCen) {
                // penampung jarak
                $jarak = 0;
                // array yang berisikan nilai pada centroid
                $nilaiCen = $valuCen['nilai'];
                // looping sebanyak nilai centroid
                foreach ($nilaiCen as $keyNilaiCen => $valueNilaiCen) {
                    // cek apakah pada mata pelajaran yang sama atau tidak
                    if (
                        ($valueNilaiSiswa['id_mata_pelajaran'] == 1 && $valueNilaiCen['id_mata_pelajaran'] == 1)
                        ||
                        ($valueNilaiSiswa['id_mata_pelajaran'] == 3 && $valueNilaiCen['id_mata_pelajaran'] == 3)
                    ) {
                        // hitung jarak dengan euclidian distance
                        $jarak = $this->euclidianceDistance($valueNilaiSiswa, $valueNilaiCen);
                    } else if ($valueNilaiSiswa['id_mata_pelajaran'] < $valueNilaiCen['id_mata_pelajaran']) {
                        break;
                    }
                }
                // memasukkan jarak antara mhs(nilai) dengan centroid(nilai)
                // index 0 nilai dengan mata pelajaran mtk (1)
                // index 1 nilai dengan mata pelajaran ing (3)
                array_push($arrJarak, $jarak);
            }
            // cek apakah tempCluster kosong
            if (empty($tempCluster)) {
                array_push($tempCluster, $arrJarak);
            } else {
                // menghitung jarak sebenarnya
                // dari dua nilai
                for ($i = 0; $i < $this->k; $i++) {
                    $tempCluster[0][$i] += $arrJarak[$i];
                    $tempCluster[0][$i] = sqrt($tempCluster[0][$i]);
                }
            }
        }
        // menentukan mhs masuk pada cluster mana
        $res = array_keys($tempCluster[0], min($tempCluster[0]))[0];

        return $res;
    }

    // parameter berisikan array of nilai satu mata pelajaran
    private function euclidianceDistance($mhs, $centroid)
    {
        // asumsi itung yang beririsan aja
        $result  = 0;
        for ($i = 0; $i < 4; $i++) {
            $result += pow($mhs[$i] - $centroid[$i], 2);
        }
        $result += pow($mhs['AVG'] - $centroid['AVG'], 2);
        return $result;
    }

    private function hitungCentroidBaru()
    {
        // mengisi centroid sebelumnya dengan centroid saat ini
        $this->prevCentroid = $this->currCentroid;

        // reset nilai curr centroid
        $this->resetCentroid();

        // looping sebanyak centroid
        foreach ($this->currCentroid as $keyCen => $valuCen) {
            // array yang berisikan nilai pada centroid
            $nilaiCen = $valuCen['nilai'];
            // looping sebanyak nilai centroid
            foreach ($nilaiCen as $keyNilaiCen => $valueNilaiCen) {
                // penampung untuk anggota pada cluster tertentu (sesuai index/key)
                $anggota = $this->cluster[$keyCen];
                if (count($anggota) != 0) {
                    foreach ($anggota as $keyAnggota => $valueAnggota) {
                        // penampung untuk nilai anggota
                        $nilaiAnggota = $valueAnggota['nilai'];
                        foreach ($nilaiAnggota as $keyNilaiAnggota => $valueNilaiAnggota) {
                            if (
                                ($valueNilaiCen['id_mata_pelajaran'] == 1 && $valueNilaiAnggota['id_mata_pelajaran'] == 1
                                ||
                                $valueNilaiCen['id_mata_pelajaran'] == 3 && $valueNilaiAnggota['id_mata_pelajaran'] == 3)
                            ) {
                                // update nilai 101, 102, 111, 112
                                for ($i = 0; $i < 4; $i++) {
                                    $nilaiLama = $this->currCentroid[$keyCen]['nilai'][$keyNilaiCen][$i];
                                    $nilaiBaru = $anggota[$keyAnggota]['nilai'][$keyNilaiAnggota][$i];

                                    $this->updateNilai($keyCen, $keyNilaiCen, $nilaiLama, $nilaiBaru, $i);
                                }

                                // update nilai avg
                                $nilaiLama = $this->currCentroid[$keyCen]['nilai'][$keyNilaiCen]['AVG'];
                                $nilaiBaru = $anggota[$keyAnggota]['nilai'][$keyNilaiAnggota]['AVG'];
                                $this->updateNilai($keyCen, $keyNilaiCen, $nilaiLama, $nilaiBaru, 'AVG');
                            }
                        }
                    }
                } else {
                    // random nilai baru
                    $this->randomNilaiBaru($keyCen, $keyNilaiCen);
                }
            }
        }

        $this->hitungRata2();
    }

    private function resetCentroid()
    {
        foreach ($this->currCentroid as $keyCen => $valuCen) {
            // array yang berisikan nilai pada centroid
            $nilaiCen = $valuCen['nilai'];
            // looping sebanyak nilai centroid
            foreach ($nilaiCen as $keyNilaiCen => $valueNilaiCen) {
                for ($i = 0; $i < 4; $i++) {
                    $this->currCentroid[$keyCen]['nilai'][$keyNilaiCen][$i] = 0;
                }
                // update nilai avg
                $this->currCentroid[$keyCen]['nilai'][$keyNilaiCen]['AVG'] = 0;
            }
        }
    }

    private function updateNilai($keyCen, $keyNilaiCen, $nilaiLama, $nilaiBaru, $i)
    {
        $nilai = $nilaiLama + $nilaiBaru;
        $this->currCentroid[$keyCen]['nilai'][$keyNilaiCen][$i] = $nilai;
    }

    private function hitungRata2()
    {
        foreach ($this->currCentroid as $keyCen => $valuCen) {
            // array yang berisikan nilai pada centroid
            $nilaiCen = $valuCen['nilai'];
            // looping sebanyak nilai centroid
            $anggota = $this->cluster[$keyCen];
            $count = count($anggota);
            if ($count != 0) {
                foreach ($nilaiCen as $keyNilaiCen => $valueNilaiCen) {
                    for ($i = 0; $i < 4; $i++) {
                        $this->currCentroid[$keyCen]['nilai'][$keyNilaiCen][$i] = $this->currCentroid[$keyCen]['nilai'][$keyNilaiCen][$i] / $count;
                    }
                    // update nilai avg
                    $this->currCentroid[$keyCen]['nilai'][$keyNilaiCen]['AVG'] = $this->currCentroid[$keyCen]['nilai'][$keyNilaiCen]['AVG'] / $count;
                }
            }
        }
    }

    private function randomNilaiBaru($keyCen, $keyNilaiCen)
    {

        for ($i = 0; $i < 4; $i++) {
            $this->currCentroid[$keyCen]['nilai'][$keyNilaiCen][$i] = rand(1, 3) + rand(1, 10) / 10;
        }
        // update nilai avg
        $this->currCentroid[$keyCen]['nilai'][$keyNilaiCen]['AVG'] = rand(1, 3) + rand(1, 10) / 10;
    }

    public function cekBatas()
    {
        $batas = abs($this->J0 - $this->J1);

        if ($batas < 0.1) {
            return false;
        }

        $this->J0 = $this->J1;

        return true;
    }

    public function getCluster($idx)
    {
        return $this->cluster[$idx];
    }
}
