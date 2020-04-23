<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fakultas;

class FakultasController extends Controller
{
    public function getNamaFakultas($idProgramStudi){
        $idFakultas = floor($idProgramStudi/100);
        $fakultas = Fakultas::find($idFakultas);
        $namaFakultas = $fakultas->nama_fakultas;
        return $namaFakultas;
    }
}
