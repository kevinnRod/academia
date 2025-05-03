<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Examen extends Model
{
    use HasFactory;
    protected $table = 'tipo_examen';
    protected $primaryKey = 'idtipoexamen';
    public $timestamps=false;
    protected $fillable=['descripcion','estado'];

}
