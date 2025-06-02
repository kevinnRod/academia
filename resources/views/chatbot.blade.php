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
             console.log(response)
    const contenido = response.data.choices[0].message.content;
   
    let preguntas;

    try {
        preguntas = JSON.parse(contenido); // convierte string JSON a array
    } catch (e) {
        chat.innerHTML += `<div><strong>IA:</strong> Error al interpretar la respuesta como JSON.</div>`;
        console.error("JSON mal formado:", contenido);
        return;
    }

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

    console.log(preguntas);
})

        .catch(function (error) {
            chat.innerHTML += `<div><strong>IA:</strong> Ocurrió un error al generar preguntas.</div>`;
            console.error(error); // Muestra el error completo en consola
        });


        chat.scrollTop = chat.scrollHeight;
    });
</script>
@endsection
