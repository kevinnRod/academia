<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedioPago extends Model
{
    use HasFactory;
    protected $table = 'mediopago';
    public $timestamps=false;
    protected $primaryKey="idmediopago";

    protected $fillable=['descripcion'];
    
    public function pago(){
        return $this->hasOne(Pago::class, 'idmediopago', 'idmediopago');
    }


}
