<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MahasiswaController;
use Phpml\CrossValidation\RandomSplit;
use App\Http\Controllers\KMeansController;
use App\Http\Controllers\PearsonCorrelationPengujianController;


use Phpml\Dataset\ArrayDataset;

class PengujianController extends Controller
{

    private $train, $test;
    private $userBasedModel;
    private $error1, $error2;
    private $accuracy;
    private $metode;

    function __construct(Request $request)
    {
        $btn = $request->input();
        $idJurusan = substr($btn['btn'], 0, 3);
        $this->metode = substr($btn['btn'], 4, strlen($btn['btn']));

        $mhs = new MahasiswaController();
        $data = $mhs->index($idJurusan)->toArray();

        // untuk label setiap data
        $arrLabel = array();

        // array labelnya bisa pake id_program_studi
        foreach ($data as $m) {
            array_push($arrLabel, $m["id_program_studi"]);
        }
        // array sample dan label
        $dataset = new ArrayDataset($data, $arrLabel);

        $dataset = new RandomSplit($dataset, 0.3);

        $this->train = $dataset->getTrainSamples();
        $this->test = $dataset->getTestSamples();

        $this->accuracy = new AccuracyController();

        $this->userBasedModel = new UserBasedModelController(null, null, 1);
    }

    public function index()
    {
        if ($this->metode == 'Basic') {
            return $this->pengujianBasic();
        } else {
            // k, looping dataset sebannyak n
            return $this->pengujianKmeans(30, 30);
        }
    }

    // bts untuk jumlah k di kmeans
    // n jumlah pengulangan kmeans
    private function pengujianKmeans($bts, $n)
    {
        $result = array();

        $resultPred = array();

        // looping dari 2-10 (untuk nilai k)
        for ($k = 2; $k <= $bts; $k++) {
            $start = microtime(true);

            $tempMae = 0;
            $tempRmse = 0;
            // untuk pengujian sebanyak 30 centroid yang berbeda
            for ($i = 0; $i < $n; $i++) {
                $kmeans = new KMeansController($k, $this->train);

                $this->error1 = array();
                $this->error2 = array();
                // test = siswa
                foreach ($this->test as $t) {
                    // biar tidak ada duplikat
                    if (!array_key_exists($t["NPM"], $resultPred)) {
                        $temp = array();

                        // hitung jarak siswa dengan centroid 
                        // mengembalikan siswa masuk dalam cluster mana
                        $cluster = $kmeans->hitungJarakSiswa($t);

                        // mengubah data mhs dari seluruh mhs
                        // menjadi anggota satu cluster dengan siswa
                        $dataTrain = $kmeans->getCluster($cluster);

                        $pearon = $this->userBasedModel->calculateSimilarity($dataTrain, $t);

                        $predict = $this->userBasedModel->calculatePredict($pearon);

                        if ($predict != null) {
                            // Hitung selisih untuk mean absolute error
                            $diff1 = abs($t["IPK"] - number_format($predict[0][0], 2));
                            // Memasukkan diff1 kepada arr
                            array_push($this->error1, $diff1);

                            // Hitung selisih untuk root mean square error
                            $diff2 = pow($t["IPK"] - number_format($predict[0][0], 2), 2);
                            // Memasukkan diff1 kepada arr
                            array_push($this->error2, $diff2);

                            // isinya npm, nama programstudi, IPK, Prediksi, diff
                            array_push(
                                $temp,
                                $t["NPM"],
                                $predict[0][2],
                                $t['IPK'],
                                number_format($predict[0][0], 2),
                                $diff1,
                                $diff2
                            );
                            // Memasukkan array temp pada array result
                            array_push($resultPred, $temp);
                        }
                    }
                }

                $mae = $this->accuracy->calculateMAE($this->error1);
                $rmse = $this->accuracy->calculateRMSE($this->error2);

                $tempMae += $mae;
                $tempRmse += $rmse;
            }
            $end = microtime(true);
            $times = $end - $start;

            $result[$k] = array();

            // masukin semua ke penampung
            array_push($result[$k], $tempMae / $n, $tempRmse / $n, $times);
        }
        $minMae = min(array_column($result,0));
        $minRmse = min(array_column($result,1));
        $minTime = min(array_column($result, 2));
    
        return view('/pengujian', [
            'status' => TRUE, 'resultPred' => $resultPred,
            'metode' => $this->metode, 'result' => $result,
            'minMae' => $minMae, 'minRmse' => $minRmse, 'minTime' => $minTime
        ]);
    }

    private function pengujianBasic()
    {
        $result = array();

        $this->error1 = array();
        $this->error2 = array();

        foreach ($this->test as $t) {
            $start = microtime(true);
            // biar tidak ada duplikat
            if (!array_key_exists($t["NPM"], $result)) {
                $temp = array();

                $pearon = $this->userBasedModel->calculateSimilarity($this->train, $t);

                $predict = $this->userBasedModel->calculatePredict($pearon);

                if ($predict != null) {
                    // Hitung selisih untuk mean absolute error
                    $diff1 = abs($t["IPK"] - number_format($predict[0][0], 2));
                    // Memasukkan diff1 kepada arr
                    array_push($this->error1, $diff1);

                    // Hitung selisih untuk root mean square error
                    $diff2 = pow($t["IPK"] - number_format($predict[0][0], 2), 2);
                    // Memasukkan diff1 kepada arr
                    array_push($this->error2, $diff2);

                    // isinya npm, nama programstudi, IPK, Prediksi, diff
                    array_push(
                        $temp,
                        $t["NPM"],
                        $predict[0][2],
                        $t['IPK'],
                        number_format($predict[0][0], 2),
                        $diff1,
                        $diff2
                    );
                    // Memasukkan array temp pada array result
                    array_push($result, $temp);
                }
            }
        }

        $mae = $this->accuracy->calculateMAE($this->error1);
        $rmse = $this->accuracy->calculateRMSE($this->error2);
        $end = microtime(true);
        $times = $end - $start;
        return view('/pengujian', [
            'status' => TRUE, 'result' => $result,
            'mae' => $mae, 'rmse' => $rmse,
            'times' => $times, 'metode' => $this->metode
        ]);
    }
}
