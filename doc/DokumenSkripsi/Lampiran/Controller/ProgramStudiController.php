<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Program_Studi;

class ProgramStudiController extends Controller
{
    public function getNamaProgramStudi($idProgramStudi)
    {
        $prodi = Program_Studi::find($idProgramStudi);
        $namaProdi = $prodi->nama_program_studi;
        return $namaProdi;
    }
}
