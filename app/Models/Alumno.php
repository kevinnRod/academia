<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $table = 'alumnos';
    protected $primaryKey = 'dniAlumno';
    public $timestamps=false;
    protected $fillable=['apellidos','nombres','edad','fechaNacimiento','estado', 'featured', 'idcarrera'];
    
    public function apoderado(){
        return $this->hasOne(Apoderado::class, 'dniApoderado', 'dniApoderado');
    }

    public function carrera(){
        return $this->hasOne(Carrera::class, 'idcarrera', 'idcarrera');
    }
}
