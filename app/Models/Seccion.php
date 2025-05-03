<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;
    protected $table = 'secciones';
    protected $primaryKey= 'idSeccion';
    public $timestamps=false;
    protected $fillable=['idGrado','seccion','idperiodo','aula','estado'];

    public function grado(){
        return $this->hasOne(Grado::class, 'idGrado', 'idGrado');
    }



    public function periodo(){
        return $this->hasOne(Periodo::class, 'idperiodo', 'idperiodo');
    }
}
