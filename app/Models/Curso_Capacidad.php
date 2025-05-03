<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso_Capacidad extends Model
{
    use HasFactory;
    protected $table = 'curso_capacidad';
    public $timestamps=false;

    public function curso(){
        return $this->hasOne(Curso::class, 'idCurso', 'idCurso');
    }

    public function capacidad(){
        return $this->hasOne(Capacidad::class, 'idCapacidad', 'idCapacidad');
    }
}
