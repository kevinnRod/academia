<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;
    protected $table = 'periodo';
    protected $primaryKey="idperiodo";
    protected $keyType = 'string';
    public $timestamps=false;
    protected $fillable=['fechaInicio', 'fechaTermino', 'estado'];

    public function trimestres()
    {
        return $this->hasMany(Trimestre::class, 'idperiodo', 'idperiodo');
    }
    public function ciclos()
    {
        return $this->hasMany(Ciclo::class, 'idciclo', 'idciclo');
    }
}
