<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fakultas;

class FakultasController extends Controller
{
    public function getNamaFakultas($id_program_studi){
        $id_fakultas = floor($id_program_studi/100);
        $fakultas = Fakultas::find($id_fakultas);
        $nama_fakultas = $fakultas->nama_fakultas;
        return $nama_fakultas;
    }
}
