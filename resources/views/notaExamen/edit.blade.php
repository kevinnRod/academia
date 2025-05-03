@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Notas de Examen</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('notaExamen.index') }}">Notas de Examen</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar Nota</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('message'))
                        <div class="alert alert-danger">
                            {{ session('message') }}
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="codigo" class="form-label">Código examen</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $examen->idexamen }}" disabled>
                        </div>    
                        <div class="col-md-6 mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $examen->descripcion }}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="periodo" class="form-label">Periodo</label>
                            <input type="text" class="form-control" id="periodo" value="{{ $examen->aula->ciclo->periodo->idperiodo }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tipo_ciclo" class="form-label">Tipo de Ciclo</label>
                            <input type="text" class="form-control" id="tipo_ciclo" value="{{ $examen->aula->ciclo->tipo_ciclo->descripcion }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="area" class="form-label">Área</label>
                            <input type="text" class="form-control" id="area" value="{{ $examen->aula->ciclo->area->descripcion }}" disabled>
                            <input type="hidden" id="idarea" value="{{ $examen->aula->ciclo->area->idarea }}">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ciclo" class="form-label">Ciclo</label>
                            <input type="text" class="form-control" id="ciclo" value="{{ $examen->aula->ciclo->descripcion }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="aula" class="form-label">Aula</label>
                            <input type="text" class="form-control" id="aula" value="{{ $examen->aula->descripcion }}" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="text" class="form-control" id="fecha" value="{{ $examen->fecha }}" disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tipo_examen" class="form-label">Tipo de Examen</label>
                        <input type="text" class="form-control" id="tipo_examen" value="{{ $examen->tipo_examen->descripcion }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="estado" value="{{ $examen->estado == 1 ? 'Activo' : 'Inactivo' }}" disabled>
                    </div>

                    <hr>

                    <h4 class="mb-3">Alumnos Matriculados ({{ count($matriculas) }}) - 
                        <span id="preguntas-info"></span>
                    </h4>

                    <div id="message" class="alert alert-danger d-none">La suma de las notas no puede exceder de 407.63 puntos.</div>
                    
                    <form action="{{ route('notaExamen.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="idexamen" value="{{ $examen->idexamen }}">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Alumno</th>
                                    <th>Buenas Letras</th>
                                    <th>Malas Letras</th>
                                    <th>Nota Letras</th>
                                    <th>Buenas matemática y ciencia</th>
                                    <th>Malas matemática y ciencia</th>
                                    <th>Nota matemática y ciencia</th>
                                    <th>Nota Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matriculas as $index => $matricula)
                                    @php
                                        $notaExamen = $notas->get($matricula->numMatricula);
                                        $buenasConocimiento = $notaExamen->buenasconocimiento ?? 0;
                                        $malasConocimiento = $notaExamen->malasconocimiento ?? 0;
                                        $buenasAptitud = $notaExamen->buenasaptitud ?? 0;
                                        $malasAptitud = $notaExamen->malasaptitud ?? 0;

                                        $notaConocimientos = $buenasConocimiento * 4.079 + $malasConocimiento * -1.021;
                                        $notaAptitud = $buenasAptitud * 4.079 + $malasAptitud * -1.021;
                                        $notaTotal = $notaConocimientos + $notaAptitud;
                                    @endphp

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $matricula->alumno->nombres }} {{ $matricula->alumno->apellidos }}</td>
                                        <td><input type="number" name="buenasconocimiento[{{ $matricula->numMatricula }}]" value="{{ $buenasConocimiento }}" class="form-control"></td>
                                        <td><input type="number" name="malasconocimiento[{{ $matricula->numMatricula }}]" value="{{ $malasConocimiento }}" class="form-control"></td>
                                        <td>
                                            <input type="text" 
                                                name="notaconocimientos[{{ $matricula->numMatricula }}]" 
                                                id="notaconocimientos_{{ $matricula->numMatricula }}" 
                                                value="{{ number_format($notaConocimientos, 2) }}" 
                                                class="form-control" 
                                                readonly>
                                        </td>
                                        <td><input type="number" name="buenasaptitud[{{ $matricula->numMatricula }}]" value="{{ $buenasAptitud }}" class="form-control"></td>
                                        <td><input type="number" name="malasaptitud[{{ $matricula->numMatricula }}]" value="{{ $malasAptitud }}" class="form-control"></td>
                                        <td>
                                            <input type="text" 
                                                name="notaaptitud[{{ $matricula->numMatricula }}]" 
                                                id="notaaptitud_{{ $matricula->numMatricula }}" 
                                                value="{{ number_format($notaAptitud, 2) }}" 
                                                class="form-control" 
                                                readonly>
                                        </td>
                                        <td>
                                            <input type="text" 
                                                name="notatotal[{{ $matricula->numMatricula }}]" 
                                                id="notatotal_{{ $matricula->numMatricula }}" 
                                                value="{{ number_format($notaTotal, 2) }}" 
                                                class="form-control" 
                                                readonly>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Guardar Notas</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtén el idarea desde el input oculto
        var idArea = document.getElementById("idarea").value;

        // Definir el número de preguntas por área
        var preguntas = {
            1: { conocimientos: 50, aptitud: 50 },  // Área A
            2: { conocimientos: 40, aptitud: 60 },  // Área B
            3: { conocimientos: 80, aptitud: 20 },  // Área C
            4: { conocimientos: 75, aptitud: 25 }   // Área D
        };

        // Obtener la cantidad de preguntas para el idArea actual
        var preguntasConocimientosMax = preguntas[idArea].conocimientos;
        var preguntasAptitudMax = preguntas[idArea].aptitud;

        // Mostrar las preguntas en el elemento correspondiente
        var preguntasElement = document.getElementById("preguntas-info");
        preguntasElement.textContent = "Preguntas de letras: " + preguntasConocimientosMax + " - Preguntas de matemática y ciencia: " + preguntasAptitudMax;

        // Función para validar los inputs
        function validarPreguntas(numMatricula) {
            var buenasConocimiento = parseFloat(document.querySelector(`input[name="buenasconocimiento[${numMatricula}]"]`).value) || 0;
            var malasConocimiento = parseFloat(document.querySelector(`input[name="malasconocimiento[${numMatricula}]"]`).value) || 0;
            var buenasAptitud = parseFloat(document.querySelector(`input[name="buenasaptitud[${numMatricula}]"]`).value) || 0;
            var malasAptitud = parseFloat(document.querySelector(`input[name="malasaptitud[${numMatricula}]"]`).value) || 0;

            // Validar conocimientos
            if (buenasConocimiento + malasConocimiento > preguntasConocimientosMax) {
                alert("La suma de buenas y malas preguntas de conocimientos excede el límite permitido.");
                document.querySelector(`input[name="buenasconocimiento[${numMatricula}]"]`).value = Math.min(buenasConocimiento, preguntasConocimientosMax - malasConocimiento);
                document.querySelector(`input[name="malasconocimiento[${numMatricula}]"]`).value = Math.min(malasConocimiento, preguntasConocimientosMax - buenasConocimiento);
            }

            // Validar aptitud
            if (buenasAptitud + malasAptitud > preguntasAptitudMax) {
                alert("La suma de buenas y malas preguntas de aptitud excede el límite permitido.");
                document.querySelector(`input[name="buenasaptitud[${numMatricula}]"]`).value = Math.min(buenasAptitud, preguntasAptitudMax - malasAptitud);
                document.querySelector(`input[name="malasaptitud[${numMatricula}]"]`).value = Math.min(malasAptitud, preguntasAptitudMax - buenasAptitud);
            }
        }

        // Función para calcular las notas
        function calcularNotas(numMatricula) {
            var buenasConocimiento = parseFloat(document.querySelector(`input[name="buenasconocimiento[${numMatricula}]"]`).value) || 0;
            var malasConocimiento = parseFloat(document.querySelector(`input[name="malasconocimiento[${numMatricula}]"]`).value) || 0;
            var buenasAptitud = parseFloat(document.querySelector(`input[name="buenasaptitud[${numMatricula}]"]`).value) || 0;
            var malasAptitud = parseFloat(document.querySelector(`input[name="malasaptitud[${numMatricula}]"]`).value) || 0;

            var notaConocimientos = (buenasConocimiento * 4.079) + (malasConocimiento * -1.021);
            var notaAptitud = (buenasAptitud * 4.079) + (malasAptitud * -1.021);
            var notaTotal = notaConocimientos + notaAptitud;

            document.getElementById(`notaconocimientos_${numMatricula}`).value = notaConocimientos.toFixed(2);
            document.getElementById(`notaaptitud_${numMatricula}`).value = notaAptitud.toFixed(2);
            document.getElementById(`notatotal_${numMatricula}`).value = notaTotal.toFixed(2);
        }

        // Agregar eventos de entrada a los campos de buenas y malas respuestas
        document.querySelectorAll('input[name^="buenasconocimiento"], input[name^="malasconocimiento"], input[name^="buenasaptitud"], input[name^="malasaptitud"]').forEach(function(element) {
            element.addEventListener('input', function() {
                const numMatricula = this.name.match(/\[(\d+)\]/)[1];
                validarPreguntas(numMatricula);
                calcularNotas(numMatricula);
            });
        });
    });
</script>
@endsection

