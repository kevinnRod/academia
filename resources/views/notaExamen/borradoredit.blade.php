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

                    <h4 class="mb-3">Alumnos Matriculados ({{ count($matriculas) }})</h4>
                    <div id="message" class="alert alert-danger d-none">La suma de las notas no puede exceder de 407.63 puntos.</div>
                    
                    <form method="POST" action="{{ route('notaExamen.store') }}">
                        @csrf
                        <input type="hidden" name="idexamen" value="{{ $examen->idexamen }}">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>N° Matrícula</th>
                                    <th>DNI</th>
                                    <th>Nombres y Apellidos</th>
                                    <th>Nota de Aptitud</th>
                                    <th>Nota de Conocimientos</th>
                                    <th>Nota Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($matriculas as $index => $matricula)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $matricula->numMatricula }}</td>
                                        <td>{{ $matricula->alumno->dniAlumno }}</td>
                                        <td>{{ $matricula->alumno->apellidos }} {{ $matricula->alumno->nombres }}</td>

                                        <td>
                                            <input type="number" step="0.01" class="form-control nota-aptitud" name="nota_aptitud[{{ $matricula->numMatricula }}]" value="{{ $notas[$matricula->numMatricula]->notaaptitud ?? '' }}" required>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control nota-conocimientos" name="nota_conocimientos[{{ $matricula->numMatricula }}]" value="{{ $notas[$matricula->numMatricula]->notaconocimientos ?? '' }}" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control nota-total" name="nota_total[{{ $matricula->numMatricula }}]" value="{{ $notas[$matricula->numMatricula]->notatotal ?? '' }}" readonly>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{ route('notaExamen.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notaAptitudElements = document.querySelectorAll('.nota-aptitud');
        const notaConocimientosElements = document.querySelectorAll('.nota-conocimientos');
        const maxAptitud = 122.1;
        const maxConocimientos = 285.53;
        const maxTotal = 407.63;
        const messageElement = document.getElementById('message');

        function calculateTotal(notaAptitud, notaConocimientos, notaTotal) {
            const aptitud = parseFloat(notaAptitud.value) || 0;
            const conocimientos = parseFloat(notaConocimientos.value) || 0;
            const total = aptitud + conocimientos;
            
            if (total > maxTotal) {
                messageElement.textContent = 'La nota total no puede exceder 407.63';
                messageElement.classList.remove('d-none');
                notaTotal.value = maxTotal.toFixed(2);
                return;
            }
            if (aptitud > maxAptitud) {
                messageElement.textContent = 'La nota de aptitud no puede exceder 122.1';
                messageElement.classList.remove('d-none');
                notaAptitud.value = maxAptitud.toFixed(2);
                return;
            }
            if (conocimientos > maxConocimientos) {
                messageElement.textContent = 'La nota de conocimientos no puede exceder 285.53';
                messageElement.classList.remove('d-none');
                notaConocimientos.value = maxConocimientos.toFixed(2);
                return;
            }
            
            messageElement.classList.add('d-none');
            notaTotal.value = total.toFixed(2);
        }

        notaAptitudElements.forEach((element, index) => {
            element.addEventListener('input', () => {
                const notaConocimientos = notaConocimientosElements[index];
                const notaTotal = element.closest('tr').querySelector('.nota-total');
                calculateTotal(element, notaConocimientos, notaTotal);
            });
        });

        notaConocimientosElements.forEach((element, index) => {
            element.addEventListener('input', () => {
                const notaAptitud = notaAptitudElements[index];
                const notaTotal = element.closest('tr').querySelector('.nota-total');
                calculateTotal(notaAptitud, element, notaTotal);
            });
        });
    });
</script>
@endsection


<script>
        document.querySelectorAll('input[name^="buenasconocimiento"], input[name^="malasconocimiento"], input[name^="buenasaptitud"], input[name^="malasaptitud"]').forEach(function(element) {
            element.addEventListener('input', function() {
                const numMatricula = this.name.match(/\[(\d+)\]/)[1];
                const buenasConocimiento = parseFloat(document.querySelector(`input[name="buenasconocimiento[${numMatricula}]"]`).value) || 0;
                const malasConocimiento = parseFloat(document.querySelector(`input[name="malasconocimiento[${numMatricula}]"]`).value) || 0;
                const buenasAptitud = parseFloat(document.querySelector(`input[name="buenasaptitud[${numMatricula}]"]`).value) || 0;
                const malasAptitud = parseFloat(document.querySelector(`input[name="malasaptitud[${numMatricula}]"]`).value) || 0;

                const notaConocimientos = (buenasConocimiento * 4.079) + (malasConocimiento * -1.021);
                const notaAptitud = (buenasAptitud * 4.079) + (malasAptitud * -1.021);
                const notaTotal = notaConocimientos + notaAptitud;

                document.getElementById(`notaconocimientos_${numMatricula}`).value = notaConocimientos.toFixed(2);
                document.getElementById(`notaaptitud_${numMatricula}`).value = notaAptitud.toFixed(2);
                document.getElementById(`notatotal_${numMatricula}`).value = notaTotal.toFixed(2);
            });
        });
    </script>