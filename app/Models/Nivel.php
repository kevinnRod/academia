<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;
    protected $table = 'niveles';
    protected $primaryKey="idNivel";

    public function cursos(){
        return $this->hasMany(Curso::class, 'idNivel', 'idNivel');
    }
}
