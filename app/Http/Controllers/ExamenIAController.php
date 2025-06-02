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

       $prompt = 'Devuélveme **solo** un arreglo JSON con 5 preguntas de opción múltiple para un examen.No debes enviarme codigo de python ni ningun lenguaje, SOLO FORMATO JSON. Cada elemento del arreglo debe ser un objeto con estas tres claves:
1. "pregunta": El enunciado de la pregunta en español.2. "opciones": Un objeto con cuatro pares clave–valor, donde las claves sean "A", "B", "C" y "D", y los valores sean las cuatro alternativas en texto.  
3. "respuesta_correcta": Una de las letras "A", "B", "C" o "D" indicando cuál de las opciones es la correcta. El tema del examen es "{$tema}" y el curso es "{$curso}". No agregues ningún texto antes ni después del JSON, solo el arreglo. Ejemplo de estructura de salida:
[
  {
    "pregunta": "¿Cuál es la capital de Perú?",
    "opciones": {
      "A": "Lima",
      "B": "Cusco",
      "C": "Arequipa",
      "D": "Trujillo"
    },
    "respuesta_correcta": "A"
  },
  {
    "pregunta": "¿Qué órgano produce la insulina?",
    "opciones": {
      "A": "Hígado",
      "B": "Páncreas",
      "C": "Riñón",
      "D": "Corazón"
    },
    "respuesta_correcta": "B"
  },
  …
]';

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
