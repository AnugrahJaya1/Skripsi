<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Program_Studi;

class ProgramStudiController extends Controller
{
    public function getNamaProgramStudi($id_program_studi)
    {
        $prodi = Program_Studi::find($id_program_studi);
        $nama_prodi = $prodi->nama_program_studi;
        return $nama_prodi;
    }
}
