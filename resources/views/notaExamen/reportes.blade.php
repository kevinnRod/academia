@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Listado de Exámenes</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('examen.index') }}">Exámenes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Reportes</li>

@endsection

@section('contenido')
    <style>
    #graficoContainer {
        display: flex;
        justify-content: center; /* Centra horizontalmente */
        align-items: center; /* Centra verticalmente */
        height: 400px; /* Ajusta la altura según sea necesario */
        margin-top: 20px; /* Ajusta el margen superior según sea necesario */
    }

    canvas {
        max-width: 100%;
        max-height: 100%;
    }

    .color-box {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

    </style>
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                <div class="row mb-3">
                    <!-- Primera columna con el formulario de filtros -->
                    <div class="col-md-6">
                        <form action="{{ route('notaExamen.reportes') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" name="buscarpor" class="form-control" placeholder="Buscar por descripción" value="{{ request('buscarpor') }}">
                                <button class="btn btn-primary" type="submit">Buscar</button>
                            </div>
                            <div class="row mb-3">
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
                            <div class="row mb-3">
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

                    <!-- Segunda columna con el botón "Crear Examen" y el formulario de gráficos -->
                    <div class="col-md-6">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                            <form id="form-graficos">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <select id="tipoGrafico" class="form-select">
                                            <option value="">-- Seleccione un tipo de gráfico --</option>
                                            <option value="pie">Gráfico Circular</option>
                                            <option value="bar">Gráfico de Barras</option>
                                            <!-- Agregar más opciones de gráficos si es necesario -->
                                        </select>
                                    </div>
                                </div>
                            </form>
                            </div>

                            <div class="col-md-6 mb-3">
                                <h3>Escala de colores de notas:</h3>
                                <div><span class="color-box" style="background-color: red;"></span>0 - 50</div>
                                <div><span class="color-box" style="background-color: #ff4500;"></span>51 - 100</div>
                                <div><span class="color-box" style="background-color: orange;"></span>101 - 150</div>
                                <div><span class="color-box" style="background-color: yellow;"></span>151 - 200</div>
                                <div><span class="color-box" style="background-color: lightgreen;"></span>201 - 250</div>
                                <div><span class="color-box" style="background-color: green;"></span>251 - 300</div>
                                <div><span class="color-box" style="background-color: #006400;"></span>301 en adelante</div>


                            </div>



                        </div>
                    </div>
                </div>


                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Periodo</th>
                                <th>Tipo ciclo</th>
                                <th>Área</th>
                                <th>Ciclo</th>
                                <th>Aula</th>
                                <th>Fecha</th>
                                <th>Tipo de Examen</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($examenes as $examen)
                                <tr>
                                    <td>{{ $examen->descripcion }}</td>
                                    <td>{{ $examen->aula->ciclo->idperiodo }}</td>
                                    <td>{{ $examen->aula->ciclo->tipo_ciclo->descripcion }}</td>
                                    <td>{{ $examen->aula->ciclo->area->descripcion }}</td>
                                    <td>{{ $examen->aula->ciclo->descripcion }}</td>
                                    <td>{{ $examen->aula->descripcion }}</td>
                                    <td>{{ $examen->fecha }}</td>
                                    <td>{{ $examen->tipo_examen->descripcion ?? 'N/A' }}</td>
                                    <td>{{ $examen->estado == 1 ? 'Activo' : 'Inactivo' }}</td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="generarGrafico({{ $examen->idexamen }}, document.getElementById('tipoGrafico').value)">Generar Gráfico</button>
                                        <a href="{{ route('notaExamen.imprimir', $examen->idexamen) }}" target="_blank" class="btn btn-sm btn-success">Imprimir</a>
                                        <a href="{{ route('pdf.sinFormato', $examen->idexamen) }}" class="btn btn-sm btn-secondary" target="_blank">Sin Formato</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table><br>
                    <h4 id="alumnos-count" class="text-center"></h4>
                    <div id="graficoContainer" class="mt-4">
                        <canvas id="graficoCircular" style="display: none;"></canvas>
                        <canvas id="graficoBarras" style="display: none;"></canvas>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $examenes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <div class="row">
        <div class="col-md-12">
            
            <canvas id="graficoCanvas"></canvas>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> <!-- Añadir esta línea para utilizar el plugin de datalabels -->

<script>
    let chartCircular = null;
    let chartBarras = null;
    
    function generarGrafico(idexamen, tipoGrafico) {
        console.log("asdas");
        var alumnosCountElement = document.getElementById('alumnos-count');
        alumnosCountElement.innerHTML = '';
        const ctxCircular = document.getElementById('graficoCircular').getContext('2d');
        const ctxBarras = document.getElementById('graficoBarras').getContext('2d');

        if (chartCircular) {
            chartCircular.destroy();
        }
        if (chartBarras) {
            chartBarras.destroy();
        }

        fetch(`/datos-grafico/${idexamen}`)
            .then(response => response.json())
            .then(data => {
                alumnosCountElement.innerHTML = `Número de alumnos: ${data.totalAlumnos}`;
                document.getElementById('graficoCircular').style.display = 'none';
                document.getElementById('graficoBarras').style.display = 'none';

                if (tipoGrafico === 'pie') {
                    document.getElementById('graficoCircular').style.display = 'block';

                    chartCircular = new Chart(ctxCircular, {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.data,
                                backgroundColor: [
                                    'red',
                                    '#ff4500',
                                    'orange',
                                    'yellow',
                                    'lightgreen',
                                    'green',
                                    '#006400'
                                ],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            const label = tooltipItem.label || '';
                                            const value = tooltipItem.raw || 0;
                                            return `${label}: ${value} alumnos`;
                                        }
                                    }
                                }
                            }
                        }
                    });

                } else if (tipoGrafico === 'bar') {
                    document.getElementById('graficoBarras').style.display = 'block';

                    chartBarras = new Chart(ctxBarras, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Número de Alumnos',
                            data: data.data,
                            backgroundColor: [
                                'red',
                                '#ff4500',
                                'orange',
                                'yellow',
                                'lightgreen',
                                'green',
                                '#006400' // Verde oscuro
                            ],
                            datalabels: {
                                color: function(context) {
                                    var backgroundColor = context.dataset.backgroundColor[context.dataIndex];
                                    // Cambiar el color de la etiqueta según el color de fondo
                                    if (backgroundColor === '#006400') { // Para la barra verde oscuro
                                        return 'white'; // Cambia el texto a blanco
                                    } else {
                                        return 'black'; // Texto negro para los otros colores
                                    }
                                },
                                align: 'start',
                                anchor: 'end',
                                formatter: function(value) {
                                    return value;
                                },
                                font: {
                                    size: 16, // Aumenta el tamaño de las letras (puedes ajustar este valor)
                                    weight: 'bold'
                                }
                            }
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Rango de notas'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Cantidad de alumnos'
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
                                        const label = tooltipItem.label || '';
                                        const value = tooltipItem.raw || 0;
                                        return `${label}: ${value} alumnos`;
                                    }
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels] // Activar el plugin de datalabels
                });

                }
            });
    }

    document.querySelectorAll('button[data-idexamen]').forEach(button => {
        button.addEventListener('click', function() {
            const idexamen = this.getAttribute('data-idexamen');
            const tipoGrafico = document.getElementById('tipoGrafico').value;
            if (tipoGrafico) {
                generarGrafico(idexamen, tipoGrafico);
            } else {
                alert('Seleccione un tipo de gráfico.');
            }
        });
    });
</script>





@endsection
