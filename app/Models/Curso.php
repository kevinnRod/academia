<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $table = 'cursos';
    protected $primaryKey = 'idCurso';
    public $timestamps=false;
    protected $fillable=['codCurso','curso','idNivel','estado', 'idperiodo', 'idciclo'];
    
    public function nivel(){
        return $this->hasOne(Nivel::class, 'idNivel', 'idNivel');
    }

    public function periodo(){
        return $this->hasOne(Periodo::class, 'idperiodo', 'idperiodo');
    }
    public function ciclo(){
        return $this->hasOne(Ciclo::class, 'idciclo', 'idciclo');
    }

    public function capacidades(){
        return $this->hasMany(Capacidad::class, 'idCurso', 'idCurso');
    }
    public function catedras(){
        return $this->hasMany(Catedra::class, 'idcatedra', 'idcatedra');
    }
}
