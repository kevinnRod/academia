<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaExamen extends Model
{
    use HasFactory;
    protected $table = 'notaexamen';
    public $timestamps=false;
    protected $primaryKey="idnota";

    protected $fillable=['idexamen','numMatricula', 'notaconocimientos', 'notaaptitud', 'notatotal', 'buenasconocimiento', 'malasconocimiento', 'buenasaptitud', 'malasaptitud'];
    
    public function examen(){
        return $this->hasOne(Examen::class, 'idexamen', 'idexamen');
    }
    
    public function matricula(){
        return $this->hasOne(Matricula::class, 'numMatricula', 'numMatricula');
    }

}
