<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;
    protected $table = 'examen';
    protected $primaryKey = 'idexamen';
    public $timestamps=false;
    protected $fillable=['descripcion','fecha','idaula', 'idtipoexamen', 'estado'];
    
    public function aula(){
        return $this->hasOne(Aula::class, 'idaula', 'idaula');
    }
    public function tipo_examen(){
        return $this->hasOne(Tipo_Examen::class, 'idtipoexamen', 'idtipoexamen');
    }
    public function nota(){
        return $this->hasMany(Nota::class, 'idnota', 'idnota');
    }

    public function notas()
    {
        return $this->hasMany(NotaExamen::class, 'idexamen', 'idexamen');
    }



}
