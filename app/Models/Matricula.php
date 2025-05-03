<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;
    protected $table = 'matriculas';
    protected $primaryKey = 'numMatricula';
    public $timestamps=false;
    protected $fillable=['fechaMatricula','idciclo','dniAlumno', 'horaMatricula', 'idaula', 'estado'];
    
    public function alumno(){
        return $this->hasOne(Alumno::class, 'dniAlumno', 'dniAlumno');
    }

    public function aula(){
        return $this->hasOne(Aula::class, 'idaula', 'idaula');
    }

    public function ciclo(){
        return $this->hasOne(Ciclo::class, 'idciclo', 'idciclo');
    }

    public function pagos(){
        return $this->hasMany(Pago::class, 'numMatricula', 'numMatricula');
    }
    
}
