<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    protected $table = 'aula';
    protected $primaryKey = 'idaula';
    public $timestamps=false;
    protected $fillable=['descripcion','idciclo','rutaHorario','estado'];

    public function ciclo(){
        return $this->hasOne(Ciclo::class, 'idciclo', 'idciclo');
    }

    public function catedras(){
        return $this->hasMany(Catedra::class, 'idaula', 'idaula');
    }

}
