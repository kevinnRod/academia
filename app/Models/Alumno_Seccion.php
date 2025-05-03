<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno_Seccion extends Model
{
    use HasFactory;
    protected $table = 'alumno_seccion';
    protected $primaryKey = 'dniAlumno';
    public $timestamps=false;
    protected $fillable=['estado'];
    
    public function alumno(){
        return $this->hasOne(Alumno::class, 'dniAlumno', 'dniAlumno');
    }

    public function seccion(){
        return $this->hasOne(Seccion::class, 'idSeccion', 'idSeccion');
    }

    public function grado(){
        return $this->hasOne(Grado::class, 'idGrado', 'idGrado');
    }
}
