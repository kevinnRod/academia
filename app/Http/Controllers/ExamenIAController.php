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
        
        $prompt = "Genera 5 preguntas tipo alternativa para un examen del curso {$curso}, sobre el tema {$tema}, incluyendo la respuesta correcta y tres alternativas incorrectas.";
    
        $response = Http::withHeaders([
            'api-key' => env('AZURE_OPENAI_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('AZURE_OPENAI_ENDPOINT') . '/openai/deployments/' . env('AZURE_OPENAI_DEPLOYMENT') . '/chat/completions?api-version=2024-02-15-preview', [
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un generador de exámenes. Devuelve las preguntas en formato JSON.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.5,
            'max_tokens' => 1000,
        ]);
    
        $data = $response->json();
    
        return response()->json($data['choices'][0]['message']['content']);
    }
    }
