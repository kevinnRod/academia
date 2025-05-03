<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $table = 'area';
    protected $primaryKey = 'idarea';
    public $timestamps=false;
    protected $fillable=['descripcion','estado'];


    public function carreras(){
        return $this->hasMany(Carrera::class, 'idcarrera', 'idcarrera');
    }

    public function ciclos(){
        return $this->hasMany(Ciclo::class, 'idciclo', 'idciclo');
    }
}
