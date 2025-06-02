<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\BedrockRuntime\BedrockRuntimeClient;
use Illuminate\Support\Facades\Http;

class ExamenIAController extends Controller
{
    public function generarPreguntas(Request $request)
    {
        $tema  = $request->input('tema');
        $curso = $request->input('curso');

        $prompt = "Genera 5 preguntas tipo alternativa para un examen del curso {$curso}, sobre el tema {$tema}, incluyendo la respuesta correcta y tres alternativas incorrectas. Devuelve las preguntas en un array JSON, cada objeto debe tener 'pregunta', 'opciones' y 'respuesta_correcta'.";

        // Instancia el cliente de Bedrock
        $client = new BedrockRuntimeClient([
            'region'      => env('AWS_DEFAULT_REGION'),
            'version'     => 'latest',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        try {
            // Prepara el cuerpo de la petición para Meta Llama 3
            $body = [
                'prompt'      => $prompt,
                'temperature' => 0.7,
                'top_p'       => 0.9,
                'max_gen_len' => 1024,
            ];

            // Invoca el modelo usando el modelId desde .env (por ejemplo meta.llama3-70b-instruct-v1:0)
            $result = $client->invokeModel([
                'modelId'     => env('AWS_BEDROCK_MODEL_ID'),
                'contentType' => 'application/json',
                'accept'      => 'application/json',
                'body'        => json_encode($body),
            ]);

            // Obtiene el contenido de la respuesta
            $responseBody = $result['body']->getContents();

            // Decodifica directamente como JSON (asumiendo que el modelo devuelve JSON puro)
            $decoded = json_decode($responseBody, true);

            // Si no se pudo decodificar correctamente, intenta extraer un bloque JSON
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Busca un array JSON dentro del texto devuelto
                $matches = [];
                preg_match('/\[\s*\{.*\}\s*\]/s', $responseBody, $matches);

                if (!empty($matches)) {
                    $decoded = json_decode($matches[0], true);
                } else {
                    return response()->json([
                        'error'   => 'La respuesta no contiene un JSON válido.',
                        'rawText' => $responseBody,
                    ], 500);
                }
            }

            return response()->json($decoded);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al consumir Bedrock: ' . $e->getMessage()
            ], 500);
        }
    }    
}
