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

        try {
            const response = await axios.post('/generar-preguntas', {
                curso: curso,
                tema: tema
            });

            chat.innerHTML += `<div style="white-space: pre-wrap;"><strong>IA:</strong> ${response.data}</div>`;
        } catch (error) {
            chat.innerHTML += `<div><strong>IA:</strong> Ocurrió un error al generar preguntas.</div>`;
        }

        chat.scrollTop = chat.scrollHeight;
    });
</script>
@endsection
