<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = "mahasiswa";
    protected $primaryKey = "id_mahasiswa";

    protected $fillable = [
        'id_mahasiswa',
        'NPM',
        'IPK',
        'id_jurusan',
        'id_program_studi'
    ];

    public function jurusanSMA()
    {
        return $this->belongsTo('App\Jurusan_SMA','id_jurusan','id_jurusan');
    }

    public function programStudi(){
        return $this->belongsTo('App\Program_Studi','id_program_studi','id_program_studi');
    }

    public function nilai(){
        return $this->hasMany('App\Nilai','id_mahasiswa','id_mahasiswa');
    }
}
