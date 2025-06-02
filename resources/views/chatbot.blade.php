@extends('layouts.plantilla') {{-- Usa tu layout base si tienes uno --}}

@section('contenido')
<div class="container">
    <h2>Generador de Exámenes con IA</h2>

    <div id="chat" style="height: 400px; overflow-y: auto; background: #f9f9f9; padding: 10px; border: 1px solid #ccc; margin-bottom: 20px;">
        <!-- Mensajes aparecerán aquí -->
    </div>

    <form id="chat-form">
        @csrf
        <div class="form-group">
            <input type="text" id="curso" class="form-control" placeholder="Curso" required>
        </div>
        <div class="form-group mt-2">
            <input type="text" id="tema" class="form-control" placeholder="Tema" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Generar Preguntas</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Función que intenta limpiar el contenido recibido desde la IA
function limpiarJsonGenerado(contenidoCrudo) {
    // Intenta detectar si hay un print() y extraer solo el contenido entre comillas
    const printRegex = /print\(['"`]([\s\S]*?)['"`]\)/;
    let match = contenidoCrudo.match(printRegex);

    if (match && match[1]) {
        contenidoCrudo = match[1];
    }

    // Elimina comillas triples si existen
    contenidoCrudo = contenidoCrudo.replace(/^"""\s*|\s*"""$/g, '').trim();

    return contenidoCrudo;
}

// Función que intenta parsear el contenido a JSON válido
function intentarParsearJSON(texto) {
    try {
        const json = JSON.parse(texto);
        return { exito: true, datos: json };
    } catch (error) {
        console.error("JSON mal formado:", texto);
        return { exito: false, error: "Error al interpretar el JSON generado." };
    }
}

    const form = document.getElementById('chat-form');
    const chat = document.getElementById('chat');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const curso = document.getElementById('curso').value;
        const tema = document.getElementById('tema').value;

        chat.innerHTML += `<div><strong>Tú:</strong> Curso: ${curso}, Tema: ${tema}</div>`;

        axios.post('/generar-preguntas', {
            curso: curso,
            tema: tema
        })
         .then(function (response) {
             console.log("Contenido crudo recibido:", response);

        // 1) Aquí “response.data” ya es directamente el arreglo de preguntas,
        //    NO tienes que ir a response.data.choices[...] ni extraer .message.content.
       let contenido = response.data.generation;

// Extrae el JSON desde el string, quitando print( y las comillas triples, si existen
// Intenta detectar si hay un print( y extraer solo el contenido entre comillas

const printRegex = /print\(['"`]([\s\S]*?)['"`]\)/;
const match = contenido.match(jsonRegex);

if (match && match[1]) {
    contenido = match[1];
}
contenido = contenido.replace(/^"""\s*|\s*"""$/g, '').trim();

// Intenta parsear el JSON (debe ser un string de un array)
let preguntas;

try {
    preguntas = JSON.parse(contenido);
} catch (e) {
    chat.innerHTML += <div><strong>IA:</strong> Error al interpretar el JSON generado.</div>;
    console.error("JSON mal formado:", contenido);
    return;
}

// Validación de que sea un array
if (!Array.isArray(preguntas)) {
    chat.innerHTML += <div><strong>IA:</strong> Formato inesperado: no se recibió un array de preguntas.</div>;
    console.error('Esperaba un array, pero recibí:', preguntas);
    return;
}


        // 2) Valida que sí recibiste un array
        if (!Array.isArray(preguntas)) {
            chat.innerHTML += <div><strong>IA:</strong> <em>Formato inesperado: no se recibió un array de preguntas.</em></div>;
            console.error('Esperaba un array, pero recibí:', response.data);
            return;
        }

        // 3) Recorre y formatea cada pregunta
        let contenidoFormateado = '<strong>IA:</strong><br><br>';
        preguntas.forEach((preguntaObj, index) => {
            contenidoFormateado += <strong>${index + 1}. ${preguntaObj.pregunta}</strong><br>;

            // Como “opciones” es un objeto { A: "...", B: "...", C: "...", D: "..." }
            for (const letra in preguntaObj.opciones) {
                if (preguntaObj.opciones.hasOwnProperty(letra)) {
                    contenidoFormateado += ${letra}) ${preguntaObj.opciones[letra]}<br>;
                }
            }

            contenidoFormateado += <em>Respuesta correcta:</em> ${preguntaObj.respuesta_correcta}<br><br>;
        });

        chat.innerHTML += <div class="msg bot">${contenidoFormateado}</div>;
        chat.scrollTop = chat.scrollHeight;
    })
        .catch(function (error) {
            chat.innerHTML += <div><strong>IA:</strong> Ocurrió un error al generar preguntas.</div>;
            console.error(error); // Muestra el error completo en consola
        });


        chat.scrollTop = chat.scrollHeight;
    });
</script>
@endsection
