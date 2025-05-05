<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;
    protected $table = 'docentes';
    protected $primaryKey = 'codDocente';
    public $timestamps=false;
    protected $fillable=['apellidos','nombres','direccion','idEstadoCivil','telefono','fechaIngreso','idNivel','estado', 'idperiodo', 'featured'];

    public function nivel(){
        return $this->hasOne(Nivel::class, 'idNivel', 'idNivel');
    }

    public function estadoCivil(){
        return $this->hasOne(EstadoCivil::class, 'idEstadoCivil', 'idEstadoCivil');
    }
    
    public function getFeaturedSasUrlAttribute()
    {
        if (!$this->featured) {
            return null;
        }
    
        $accountName = env('AZURE_STORAGE_NAME');
        $container = env('AZURE_STORAGE_CONTAINER');
        $sasToken = env('AZURE_STORAGE_SAS_TOKEN');
    
        return "https://{$accountName}.blob.core.windows.net/{$container}/{$this->featured}?{$sasToken}";
    }
    
}
