<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaCorrecta extends Model
{
    use HasFactory;

    protected $table = 'respuestas_correctas';
    public $timestamps = false;

    protected $fillable = [
        'id_examen',
        'numero_pregunta',
        'alternativa_correcta',
    ];

    public function examen()
    {
        return $this->belongsTo(Examen::class, 'id_examen');
    }
}
