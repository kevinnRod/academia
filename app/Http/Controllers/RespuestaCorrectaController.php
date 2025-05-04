<?php
namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\RespuestaCorrecta;
use Illuminate\Http\Request;


class RespuestaCorrectaController extends Controller
{

    public function editPorExamen($idExamen)
    {
        $examen = Examen::findOrFail($idExamen);
        $respuestas = RespuestaCorrecta::where('id_examen', $idExamen)->orderBy('numero_pregunta')->get();

        return view('respuestas_correctas.edit', compact('examen', 'respuestas'));
}

public function updatePorExamen(Request $request, $idExamen)
{
    $respuestasInput = $request->input('respuestas', []);

    foreach ($respuestasInput as $numeroPregunta => $alternativa) {
        if (!in_array($alternativa, ['a', 'b', 'c', 'd', 'e'])) {
            continue; // Ignora si está vacío o no es válido
        }
    
        RespuestaCorrecta::updateOrCreate(
            [
                'id_examen' => $idExamen,
                'numero_pregunta' => $numeroPregunta,
            ],
            [
                'alternativa_correcta' => strtolower($alternativa),
            ]
        );
    }

    return redirect()
        ->route('examen.index')
        ->with('success', 'Respuestas correctas actualizadas correctamente.');
}


}
