<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente_Curso extends Model
{
    use HasFactory;
    protected $table = 'docente_curso';
    public $timestamps=false;
    protected $fillable=['idperiodo', 'idSeccion', 'idGrado', 'estado'];
    
    public function docente(){
        return $this->hasOne(Docente::class, 'codDocente', 'codDocente');
    }

    public function curso(){
        return $this->hasOne(Curso::class, 'idCurso', 'idCurso');
    }

    public function anyoescolar(){
        return $this->hasOne(Periodo::class, 'idperiodo', 'idperiodo');
    }

    public function seccion(){
        return $this->hasOne(Seccion::class, 'idSeccion', 'idSeccion');
    }

    public function grado(){
        return $this->hasOne(Grado::class, 'idGrado', 'idGrado');
    }
}
