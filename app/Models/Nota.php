<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;
    protected $table = 'nota';
    public $timestamps=false;
    protected $primaryKey="idnotaTrimestre";

    protected $fillable=['dniAlumno','nota', 'idcapacidad', 'idtrimestre', 'codDocente', 'idperiodo', 'idGrado', 'idSeccion', 'idCurso'];
    
    public function docente(){
        return $this->hasOne(Docente::class, 'codDocente', 'codDocente');
    }

    public function curso(){
        return $this->hasOne(Curso::class, 'idCurso', 'idCurso');
    }

    public function capacidad(){
        return $this->hasOne(Capacidad::class, 'idcapacidad', 'idcapacidad');
    }

    public function periodo(){
        return $this->hasOne(Periodo::class, 'idperiodo', 'idperiodo');
    }

    public function alumno(){
        return $this->hasOne(Alumno::class, 'dniAlumno', 'dniAlumno');
    }

    public function seccion(){
        return $this->hasOne(Seccion::class, 'idSeccion', 'idSeccion');
    }

    public function grado(){
        return $this->hasOne(Grado::class, 'idGrado', 'idGrado');
    }

    public function trimestre(){
        return $this->hasOne(Trimestre::class, 'idtrimestre', 'idtrimestre');
    }
}
