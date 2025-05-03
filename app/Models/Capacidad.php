<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacidad extends Model
{
    use HasFactory;
    protected $table = 'capacidad';
    protected $primaryKey = 'idcapacidad';
    public $timestamps=false;
    protected $fillable=['idcurso','descripcion','estado', 'idperiodo'];

    public function curso(){
        return $this->hasOne(Curso::class, 'idCurso', 'idCurso');
    }
    public function periodo(){
        return $this->hasOne(Periodo::class, 'idperiodo', 'idperiodo');
    }
}
