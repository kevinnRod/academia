<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $table = 'pago';
    public $timestamps=false;
    protected $primaryKey="idpago";

    protected $fillable=['nropago', 'numMatricula', 'fecha', 'monto', 'rutaImagen', 'idmediopago', 'estado'];

    public function matricula()
    {
        return $this->hasOne(Matricula::class, 'numMatricula', 'numMatricula');
    }

    public function mediospago()
    {
        return $this->hasMany(MedioPago::class, 'idmediopago', 'idmediopago');
    }

}
