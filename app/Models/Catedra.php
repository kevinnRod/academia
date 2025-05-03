<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catedra extends Model
{
    use HasFactory;
    protected $table = 'catedra';
    protected $primaryKey = 'idcatedra';
    public $timestamps=false;
    protected $fillable=['codDocente', 'idcurso', 'idaula', 'estado'];

    public function curso(){
        return $this->hasOne(Cursoo::class, 'idcurso', 'idcurso');
    }

    public function aula(){
        return $this->hasOne(Aula::class, 'idaula', 'idaula');
    }
    
    public function docente(){
        return $this->hasOne(Docente::class, 'codDocente', 'codDocente');
    }
}
