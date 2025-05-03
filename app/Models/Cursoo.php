<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursoo extends Model
{
    use HasFactory;
    protected $table = 'curso';
    protected $primaryKey = 'idcurso';
    public $timestamps=false;
    protected $fillable=['descripcion', 'estado'];
    
    public function catedras(){
        return $this->hasMany(Catedra::class, 'idcurso', 'idcurso');
    }


}
