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

    let contenido = response.data.generation;

    // LIMPIA el contenido recibido
    contenido = limpiarJsonGenerado(contenido);

    // INTENTA parsearlo como JSON
    const resultado = intentarParsearJSON(contenido);

    if (!resultado.exito) {
        chat.innerHTML += `<div><strong>IA:</strong> ${resultado.error}</div>`;
        return;
    }

    const preguntas = resultado.datos;

    // Valida que sea un array
    if (!Array.isArray(preguntas)) {
        chat.innerHTML += `<div><strong>IA:</strong> Formato inesperado: no se recibió un array de preguntas.</div>`;
        console.error('Esperaba un array, pero recibí:', preguntas);
        return;
    }

    // Muestra el contenido formateado
    let contenidoFormateado = '<strong>IA:</strong><br><br>';
    preguntas.forEach((preguntaObj, index) => {
        contenidoFormateado += `<strong>${index + 1}. ${preguntaObj.pregunta}</strong><br>`;

        for (const letra in preguntaObj.opciones) {
            if (preguntaObj.opciones.hasOwnProperty(letra)) {
                contenidoFormateado += `${letra}) ${preguntaObj.opciones[letra]}<br>`;
            }
        }

        contenidoFormateado += `<em>Respuesta correcta:</em> ${preguntaObj.respuesta_correcta}<br><br>`;
    });

    chat.innerHTML += `<div class="msg bot">${contenidoFormateado}</div>`;
    chat.scrollTop = chat.scrollHeight;
})
.catch(function (error) {
    chat.innerHTML += `<div><strong>IA:</strong> Ocurrió un error al generar preguntas.</div>`;
    console.error(error);
});
</script>
@endsection
