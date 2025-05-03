@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Notas del Alumno</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('notaExamen.index') }}">Notas de Examen</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ver Notas</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm mb-4">
                <div class="card-body">
                <div class="mb-4">
                    <h4 class="mb-3">Datos del Alumno</h4>
                    <div class="row">
                        <!-- Información del Alumno -->
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <p><strong>DNI:</strong> {{ $alumno->dniAlumno }}</p>
                                    <p><strong>Apellidos:</strong> {{ $alumno->apellidos }} </p>
                                    <p><strong>Nombres:</strong> {{ $alumno->nombres }} </p>
                                    <p><strong>Fecha de Nacimiento:</strong> {{ \Carbon\Carbon::parse($alumno->fechaNacimiento)->format('d/m/Y') }}</p>
                                    <p><strong>Edad actual:</strong> {{ \Carbon\Carbon::parse($alumno->fechaNacimiento)->age }}</p>
                                    <p><strong>Carrera:</strong> {{ $alumno->carrera->descripcion }}</p>
                                    <p><strong>Área:</strong> B</p>
                                    <div class="mb-3">
                                        <strong>Foto:</strong>
                                        <a href="{{ asset($alumno->featured) }}" data-fancybox="gallery" data-caption="Foto del alumno">
                                            <img src="{{ asset($alumno->featured) }}" alt="Foto del alumno" class="img-fluid border" style="width: 210px; height: 210px; object-fit: cover;">
                                        </a>
                                    </div>
                                    <button type="button" class="btn btn-primary w-100" data-dni-alumno="{{ $alumno->dniAlumno }}" onclick="generarGraficoNotas('{{ $alumno->dniAlumno }}')">Generar Gráfico</button>
                                    <br><br>
                                    <form id="pdfForm" action="{{ route('notaExamen.generarPdf', $alumno->dniAlumno) }}"  target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" id="chartImage" name="chartImage">
                                        <button class="btn btn-primary w-100" type="submit">Generar PDF</button>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- Gráfico -->
                        <div class="col-md-8" id="grafico-container">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Gráfico de Notas</h5>
                                    <canvas id="graficoNotas" style="display: none;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        @foreach ($periodosConCiclos as $periodoConCiclos)
                        <div class="mb-4">
                            <h4 class="mb-3">Periodo: {{ $periodoConCiclos['periodo']->idperiodo }}</h4>
                            @foreach ($periodoConCiclos['ciclos'] as $cicloConExamenes)
                                <div class="mb-4">
                                    <h5>{{ $cicloConExamenes['ciclo']->descripcion }}</h5>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <p><strong>Fecha Inicio:</strong> {{ $cicloConExamenes['ciclo']->fechaInicio }}</p>
                                            <p><strong>Fecha Término:</strong> {{ $cicloConExamenes['ciclo']->fechaTermino }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Área:</strong> {{ $cicloConExamenes['ciclo']->area->descripcion }}</p>
                                            <p><strong>Tipo:</strong> {{ $cicloConExamenes['ciclo']->tipo_ciclo->descripcion }}</p>
                                        </div>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Descripción</th>
                                                <th>Aula</th>
                                                <th>Nota ciencia y matemática</th>
                                                <th>Nota letras</th>
                                                <th>Nota Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cicloConExamenes['examenes'] as $examen)
                                                @php
                                                    $nota = $examen->notas->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ $examen->fecha }}</td>
                                                    <td>{{ $examen->descripcion }}</td>
                                                    <td>{{ $examen->aula->descripcion }}</td>
                                                    <td>{{ $nota->notaaptitud ?? 'N/A' }}</td>
                                                    <td>{{ $nota->notaconocimientos ?? 'N/A' }}</td>
                                                    <td>{{ $nota->notatotal ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    @if (empty($periodosConCiclos))
                        <div class="alert alert-info">
                            No se encontraron notas de exámenes para el alumno.
                        </div>
                    @endif

                    <!-- <a  class="btn btn-sm btn-primary" onclick="generarGraficoNotas('{{ $alumno->dniAlumno }}')">Generar gráfico de notas</a> -->

                    
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> <!-- Añadir esta línea para utilizar el plugin de datalabels -->

<script>
    let chartLine = null;

    function generarGraficoNotas(dniAlumno) {
        // Obtener el contexto del gráfico
        const ctxLine = document.getElementById('graficoNotas').getContext('2d');

        // Destruir el gráfico existente, si hay uno
        if (chartLine) {
            chartLine.destroy();
        }

        // Ocultar el gráfico y mostrar el contenedor
        document.getElementById('graficoNotas').style.display = 'none';

        // Realizar la solicitud AJAX para obtener los datos del gráfico
        fetch(`/grafico-notas-alumnoLineal/${dniAlumno}`)
            .then(response => response.json())
            .then(data => {
                // Mostrar el gráfico
                document.getElementById('graficoNotas').style.display = 'block';
                console.log('Datos del gráfico:', data); // Verifica qué datos se reciben

                // Crear el gráfico lineal
                chartLine = new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: data.map(d => `${d.fecha} `),
                        datasets: [
                            {
                                label: 'Nota ciencia y matemática',
                                data: data.map(d => d.notaaptitud),
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderWidth: 2,
                                datalabels: {
                                    align: 'top',
                                    anchor: 'end',
                                    color: '#000',
                                    font: {
                                        weight: 'normal',
                                        size: 10 // Tamaño de la fuente en píxeles
                                    },
                                    
                                    formatter: function(value) {
                                        return value.toFixed(2); // Mostrar el valor formateado para Nota letras
                                    }
                                }
                            },
                            {
                                label: 'Nota letras',
                                data: data.map(d => d.notaconocimientos),
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderWidth: 2,
                                datalabels: {
                                    align: 'top',
                                    anchor: 'end',
                                    color: '#000',
                                    font: {
                                        weight: 'normal',
                                        size: 10 // Tamaño de la fuente en píxeles
                                    },
                                    formatter: function(value) {
                                        return value.toFixed(2); // Mostrar el valor formateado para Nota ciencias y matemática
                                    }
                                }
                            },
                            {
                                label: 'Nota Total',
                                data: data.map(d => d.notatotal),
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderWidth: 2,
                                datalabels: {
                                    align: 'top',
                                    anchor: 'end',
                                    color: '#000',
                                    font: {
                                        weight: 'normal',
                                        size: 10 // Tamaño de la fuente en píxeles

                                    },
                                    formatter: function(value) {
                                        return value.toFixed(2); // Mostrar el valor formateado para Nota Total
                                    }
                                }
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Fecha'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Notas'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        const label = tooltipItem.dataset.label || '';
                                        const value = tooltipItem.raw || 0;
                                        
                                        return `${label}: ${value}`;
                                    }
                                }
                            },
                            datalabels: {
                                display: true
                            }
                        },

                        
                    },
                    plugins: [ChartDataLabels] // Activar el plugin de datalabels

                });
            })
            .catch(error => {
                console.error('Error al obtener los datos del gráfico:', error);
            });
    }

    // Asignar el click handler al botón de generación del gráfico
    document.querySelector('button[data-dni-alumno]').addEventListener('click', function() {
        const dniAlumno = this.getAttribute('data-dni-alumno');
        generarGraficoNotas(dniAlumno);
    });
</script>
@endsection
