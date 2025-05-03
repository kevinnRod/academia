@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Lista de Alumnos en el Aula</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('notaExamen.index') }}">Notas de Examen</a></li>
    <li class="breadcrumb-item active" aria-current="page">Lista de Alumnos</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('notaExamen.notasAlumno') }}" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" name="buscarpor" class="form-control" placeholder="Buscar por DNI" value="{{ request('buscarpor') }}">
                                    <button class="btn btn-primary" type="submit">Buscar</button>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                    <select name="idperiodo" id="idperiodo" class="form-select" onchange="cargarTiposCiclo()">
                                        <option value="">-- Seleccione un periodo --</option>
                                        @foreach ($periodos as $periodo)
                                            <option value="{{ $periodo->idperiodo }}" {{ $periodo->idperiodo == $idperiodoSeleccionado ? 'selected' : '' }}>
                                                {{ $periodo->idperiodo }}
                                            </option>
                                        @endforeach
                                    </select>

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select name="idtipociclo" id="idtipociclo" class="form-select" onchange="cargarAreas()">
                                            <option value="">-- Seleccione un tipo de ciclo --</option>
                                            @foreach ($tiposCiclo as $tipoCiclo)
                                                <option value="{{ $tipoCiclo->idtipociclo }}" {{ request('idtipociclo') == $tipoCiclo->idtipociclo ? 'selected' : '' }}>
                                                    {{ $tipoCiclo->descripcion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select name="idarea" id="idarea" class="form-select" onchange="cargarCiclos()">
                                            <option value="">-- Seleccione un área --</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->idarea }}" {{ request('idarea') == $area->idarea ? 'selected' : '' }}>
                                                    {{ $area->descripcion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select name="idciclo" id="idciclo" class="form-select" onchange="cargarAulas()">
                                            <option value="">-- Seleccione un ciclo --</option>
                                            @foreach ($ciclos as $ciclo)
                                                <option value="{{ $ciclo->idciclo }}" {{ request('idciclo') == $ciclo->idciclo ? 'selected' : '' }}>
                                                    {{ $ciclo->descripcion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <select name="idtipoexamen" id="idtipoexamen" class="form-select">
                                        <option value="">-- Seleccione un tipo de examen --</option>
                                        @foreach ($tiposExamen as $tipoExamen)
                                            <option value="{{ $tipoExamen->idtipoexamen }}" {{ request('idtipoexamen') == $tipoExamen->idtipoexamen ? 'selected' : '' }}>
                                                {{ $tipoExamen->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mb-3">
                                    <select name="idaula" id="idaula" class="form-select">
                                        <option value="">-- Seleccione un aula --</option>
                                        @foreach ($aulas as $aula)
                                            <option value="{{ $aula->idaula }}" {{ request('idaula') == $aula->idaula ? 'selected' : '' }}>
                                                {{ $aula->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-primary" type="submit">Filtrar</button>
                            </form>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="mb-3">
                        <h5>Total de matrículas: {{ $alumnos->count() }}</h5>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>

                                <th>DNI</th>
                                <th>Alumno</th>
                                <th>Fecha Nacimiento</th>
                                <th>Nro Matricula</th>
                                <th>id</th>
                                <th>Aula</th>
                                <th>Carrera</th>
                                <th>Foto</th>
                                <th>Opciones</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnos as $alumno)
                                <tr>
                                    <td>{{ $alumno->dniAlumno }}</td>
                                    <td>{{ $alumno->nombres }} {{ $alumno->apellidos }}</td>
                                    <td>{{ $alumno->fechaNacimiento }}</td>
                                    <td>{{ $alumno->numMatricula }}</td>
                                    <td>{{ $alumno->idaula }}</td>
                                    <td>{{ $alumno->aula_descripcion }}</td>
                                    <td>{{ $alumno->carrera_descripcion }}</td>
                                    <td>
                                        <a href="{{ asset($alumno->featured) }}" data-fancybox="gallery" data-caption="Foto del alumno">
                                            <img src="{{ asset($alumno->featured) }}" alt="Foto del alumno" class="img-fluid" width="120px">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('notaExamen.verNotas', $alumno->dniAlumno) }}" target="_blank" class="btn btn-sm btn-success">Ver todas las notas</a>
                                        <a href="{{ route('notaExamen.verNotasAulaAlumno', ['idaula' => $alumno->idaula, 'dniAlumno' => $alumno->dniAlumno]) }}" target="_blank" class="btn btn-sm btn-secondary">Ver notas en el aula</a>
                                        <a  class="btn btn-sm btn-primary" onclick="generarGraficoNotas('{{ $alumno->dniAlumno }}')">Generar gráfico de notas</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($alumnos->isEmpty())
                        <div class="alert alert-info">
                            No se encontraron alumnos para el aula seleccionado.
                        </div>
                    @endif

                    <div class="mb-4" id="grafico-container">
                        <canvas id="graficoNotas" style="display: none;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function obtenerDatosGrafico(dniAlumno) {
            return fetch(`/grafico-notas/${dniAlumno}`)
                .then(response => response.json())
                .catch(error => {
                    console.error('Error al obtener los datos del gráfico:', error);
                });
        }

        function mostrarGrafico(datos) {
            var ctx = document.getElementById('graficoNotas').getContext('2d');
            var fechas = datos.map(d => d.fecha);
            var notasAptitud = datos.map(d => d.notaaptitud);
            var notasConocimientos = datos.map(d => d.notaconocimientos);
            var notasTotales = datos.map(d => d.notatotal);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: fechas,
                    datasets: [
                        {
                            label: 'Nota Aptitud',
                            data: notasAptitud,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 1
                        },
                        {
                            label: 'Nota Conocimientos',
                            data: notasConocimientos,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 1
                        },
                        {
                            label: 'Nota Total',
                            data: notasTotales,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            document.getElementById('grafico-container').style.display = 'block';
        }

        function generarGraficoNotas(dniAlumno) {
            obtenerDatosGrafico(dniAlumno).then(datos => {
                if (datos && datos.length > 0) {
                    mostrarGrafico(datos);
                } else {
                    alert('No se encontraron datos para el gráfico.');
                }
            });
        }
    </script>


@endsection


