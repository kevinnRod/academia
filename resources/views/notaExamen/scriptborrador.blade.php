<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                        labels: data.map(d => d.fecha),
                        datasets: [
                            {
                                label: 'Nota Aptitud',
                                data: data.map(d => d.notaaptitud),
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderWidth: 2
                            },
                            {
                                label: 'Nota Conocimientos',
                                data: data.map(d => d.notaconocimientos),
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderWidth: 2
                            },
                            {
                                label: 'Nota Total',
                                data: data.map(d => d.notatotal),
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderWidth: 2
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
                            }
                        }
                    }
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


public function graficoNotasAlumnoLineal($dniAlumno)
{
    // Obtener los datos del alumno
    $alumno = Alumno::where('dniAlumno', $dniAlumno)->first();

    // Si no se encuentra el alumno, retornar un error en JSON
    if (!$alumno) {
        return response()->json(['error' => 'Alumno no encontrado'], 404);
    }

    // Obtener las matrículas del alumno, junto con el aula y el ciclo asociado
    $matriculas = Matricula::where('dniAlumno', $dniAlumno)
        ->with(['aula.ciclo' => function($query) {
            $query->orderBy('fechaInicio', 'asc');
        }])
        ->get();

    // Inicializar el array para almacenar las notas
    $notas = [];

    // Recorrer cada matrícula para obtener los ciclos y los exámenes del alumno
    foreach ($matriculas as $matricula) {
        $ciclo = $matricula->aula->ciclo;

        // Obtener los exámenes del ciclo a través del aula, ordenados por fecha
        $examenes = Examen::whereHas('aula', function ($query) use ($ciclo) {
                $query->where('idciclo', $ciclo->idciclo);
            })
            ->with(['notas' => function($query) use ($dniAlumno) {
                $query->whereHas('matricula', function($query) use ($dniAlumno) {
                    $query->where('dniAlumno', $dniAlumno);
                });
            }])
            ->orderBy('fecha', 'asc')
            ->get();

        // Almacenar las notas de cada examen
        foreach ($examenes as $examen) {
            $nota = $examen->notas->first();
            if ($nota) {
                $notas[] = [
                    'fecha' => $examen->fecha,
                    'notaaptitud' => $nota->notaaptitud,
                    'notaconocimientos' => $nota->notaconocimientos,
                    'notatotal' => $nota->notatotal
                ];
            }
        }
    }

    // Ordenar el array de notas por fecha
    usort($notas, function($a, $b) {
        return strtotime($a['fecha']) - strtotime($b['fecha']);
    });

    // Retornar los datos en formato JSON
    return response()->json($notas);
}



@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                        labels: data.map(d => d.fecha),
                        datasets: [
                            {
                                label: 'Nota Aptitud',
                                data: data.map(d => d.notaaptitud),
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderWidth: 2
                            },
                            {
                                label: 'Nota Conocimientos',
                                data: data.map(d => d.notaconocimientos),
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderWidth: 2
                            },
                            {
                                label: 'Nota Total',
                                data: data.map(d => d.notatotal),
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderWidth: 2
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
                            }
                        }
                    }
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
