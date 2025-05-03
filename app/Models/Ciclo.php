<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    use HasFactory;
    protected $table = 'ciclo';
    protected $primaryKey = 'idciclo';
    public $timestamps=false;
    protected $fillable=['descripcion','fechaInicio','fechaTermino', 'idperiodo', 'idtipociclo', 'idarea', 'estado'];
    
    public function tipo_ciclo(){
        return $this->hasOne(Tipo_Ciclo::class, 'idtipociclo', 'idtipociclo');
    }

    public function periodo(){
        return $this->hasOne(Periodo::class, 'idperiodo', 'idperiodo');
    }

    public function area(){
        return $this->hasOne(Area::class, 'idarea', 'idarea');
    }




}
