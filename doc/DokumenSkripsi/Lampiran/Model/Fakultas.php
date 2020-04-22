<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table ="fakultas";

    protected $primaryKey = "id_fakultas";

    protected $fillable=[
        'id_fakultas',
        'nama_fakultas'
    ];

    public function programStudi(){
        return $this->hasMany('App\Program_Studi','id_fakultas','id_fakultas');
    }
}
