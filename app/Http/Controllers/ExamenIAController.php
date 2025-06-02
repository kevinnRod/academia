<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\BedrockRuntime\BedrockRuntimeClient;
use Illuminate\Support\Facades\Http;

class ExamenIAController extends Controller
{
    public function generarPreguntas(Request $request)
{
    $tema = $request->input('tema');
    $curso = $request->input('curso');

    $prompt = "Genera 5 preguntas tipo alternativa para un examen del curso {$curso}, sobre el tema {$tema}, incluyendo la respuesta correcta y tres alternativas incorrectas. Devuelve las preguntas en un array JSON, cada objeto debe tener 'pregunta', 'opciones' y 'respuesta_correcta'.";

    $client = new BedrockRuntimeClient([
        'region' => env('AWS_REGION'),
        'version' => 'latest',
        'credentials' => [
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
        ],
    ]);

    try {
        $body = [
            'input' => [
                ['role' => 'system', 'content' => 'Eres un generador de exámenes. Devuelve las preguntas en formato JSON válido. Devuelve 5 preguntas en español, que sean de opciones múltiples.'],
                ['role' => 'user', 'content' => $prompt],
            ]
        ];

        $result = $client->invokeModel([
            'modelId' => env('AWS_BEDROCK_MODEL_ID'),
            'contentType' => 'application/json',
            'accept' => 'application/json',
            'body' => json_encode($body),
        ]);

        $responseBody = $result['body']->getContents();
        $decoded = json_decode($responseBody, true);

        return response()->json($decoded);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al consumir Bedrock: ' . $e->getMessage()
        ], 500);
    }
}    
}
