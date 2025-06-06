<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    use HasFactory;
    protected $table = 'grados';
    protected $primaryKey="idGrado";

    public function nivel(){
        return $this->hasOne(Nivel::class, 'idNivel', 'idNivel');
    }
}
