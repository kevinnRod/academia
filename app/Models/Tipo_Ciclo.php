<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Ciclo extends Model
{
    use HasFactory;
    protected $table = 'tipo_ciclo';
    protected $primaryKey = 'idtipociclo';
    public $timestamps=false;
    protected $fillable=['descripcion','estado'];

}
