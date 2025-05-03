<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apoderado extends Model
{
    use HasFactory;
    protected $table = 'apoderados';
    protected $primaryKey = 'dniApoderado';
    public $timestamps=false;
    protected $fillable=['apellidos','nombres','edad','idEstadoCivil','telefono','direccion'];
    
    public function estadoCivil(){
        return $this->hasOne(EstadoCivil::class, 'idEstadoCivil', 'idEstadoCivil');
    }
}
