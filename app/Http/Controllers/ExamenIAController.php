<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExamenIAController extends Controller
{

    public function generarPreguntas(Request $request)
    {
        $tema = $request->input('tema'); 
        $curso = $request->input('curso');
        
        $prompt = "Genera 5 preguntas tipo alternativa para un examen del curso {$curso}, sobre el tema {$tema}, incluyendo la respuesta correcta y tres alternativas incorrectas. Devuelve las preguntas en un array JSON, cada objeto debe tener 'pregunta', 'opciones' y 'respuesta_correcta'.";
        
        $response = Http::withOptions([
            'verify' => false, 
        ])->withHeaders([
            'api-key' => '91Ah3SlCpQaNw8yT164PyCnjBzp5wXInu3kUeni4c9p0xqehgdGyJQQJ99BEACHYHv6XJ3w3AAAAACOGwl90',
            'Content-Type' => 'application/json',
        ])->post('https://ssama-maaza93a-eastus2.cognitiveservices.azure.com/' . '/openai/deployments/' . 'o3-mini' . '/chat/completions?api-version=2024-12-01-preview', [
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un generador de exámenes. Devuelve las preguntas en formato JSON válido. Devuelve 5 preguntas en español, que sean de opciones múltiples'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);
    
        $data = $response->json();
        $content = $data['choices'][0]['message']['content'] ?? '';
    
        $jsonDecoded = json_decode($content, true);
    
        // if (json_last_error() !== JSON_ERROR_NONE) {
        //     return response()->json([
        //         'error' => 'Error al decodificar el JSON generado por la IA.',
        //         'content' => $content,
        //     ], 500);
        // }
    
        return response()->json($data);
    }
    
}