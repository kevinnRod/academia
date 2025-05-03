<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;
    protected $table = 'carrera';
    protected $primaryKey = 'idcarrera';
    public $timestamps=false;
    protected $fillable=['descripcion','idarea', 'estado'];

    public function area(){
        return $this->hasOne(Area::class, 'idarea', 'idarea');
    }

}
