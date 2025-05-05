<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MicrosoftAzure\Storage\Common\Models\SharedAccessSignatureHelper;

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
        $accountKey = env('AZURE_STORAGE_KEY');
        $container = env('AZURE_STORAGE_CONTAINER');

        $sasHelper = new SharedAccessSignatureHelper($accountName, $accountKey);

        $token = $sasHelper->generateBlobServiceSharedAccessSignatureToken(
            'b',
            "$container/{$this->featured}",
            'r',
            now()->format('Y-m-d\TH:i:s\Z'),
            now()->addMinutes(15)->format('Y-m-d\TH:i:s\Z')
        );

        return "https://{$accountName}.blob.core.windows.net/{$container}/{$this->featured}?{$token}";
    }
}
