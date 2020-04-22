<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mata_Pelajaran extends Model
{
    protected $table = "mata_pelajaran";
    protected $primaryKey = "id_mata_pelajaran";

    protected $fillable = [
        'id_mata_pelajaran',
        'nama_mata_pelajaran'
    ];

    public function nilai(){
        return $this->hasMany('App\Nilai','id_mata_pelajaran','id_mata_pelajaran');
    }
}
