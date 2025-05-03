<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trimestre extends Model
{
    use HasFactory;
    protected $table = 'trimestre';
    protected $primaryKey= 'idtrimestre';
    public $timestamps=false;
    protected $fillable=['descripcion','idperiodo','estado'];

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'idperiodo', 'idperiodo');
    }
}
