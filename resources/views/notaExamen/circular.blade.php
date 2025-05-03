<!DOCTYPE html>
<html>
<head>
    <title>Gráficos de Notas del Examen</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 600px;
            margin: 20px auto;
        }
        .container {
            text-align: center;
            margin: 20px;
        }
        .charts-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .chart-wrapper {
            width: 100%;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Gráficos de Notas del Examen: {{ $examen->descripcion }}</h2>
        <div class="charts-container">
            <!-- Gráfico Circular -->
            <div class="chart-wrapper">
                <h3>Distribución de Notas (Gráfico Circular)</h3>
                <canvas id="graficoCircular"></canvas>
            </div>

            <!-- Gráfico de Barras -->
            <div class="chart-wrapper">
                <h3>Distribución de Notas (Gráfico de Barras)</h3>
                <canvas id="graficoBarras"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Datos para el gráfico circular
        const ctxCircular = document.getElementById('graficoCircular').getContext('2d');
        const datosCircular = {
            labels: ['0-50', '51-100', '101-150', '151-200', '201-250', '251-300', '301+'],
            datasets: [{
                data: [
                    {{ $rangoNotas['0-50'] }},
                    {{ $rangoNotas['51-100'] }},
                    {{ $rangoNotas['101-150'] }},
                    {{ $rangoNotas['151-200'] }},
                    {{ $rangoNotas['201-250'] }},
                    {{ $rangoNotas['251-300'] }},
                    {{ $rangoNotas['301+'] }}
                ],
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
        };

        new Chart(ctxCircular, {
            type: 'pie',
            data: datosCircular,
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

        // Datos para el gráfico de barras
        const ctxBarras = document.getElementById('graficoBarras').getContext('2d');
        const datosBarras = {
            labels: ['0-50', '51-100', '101-150', '151-200', '201-250', '251-300', '301+'],
            datasets: [{
                label: 'Número de Alumnos',
                data: [
                    {{ $rangoNotas['0-50'] }},
                    {{ $rangoNotas['51-100'] }},
                    {{ $rangoNotas['101-150'] }},
                    {{ $rangoNotas['151-200'] }},
                    {{ $rangoNotas['201-250'] }},
                    {{ $rangoNotas['251-300'] }},
                    {{ $rangoNotas['301+'] }}
                ],
                backgroundColor: [
                    'red',
                    '#ff4500',
                    'orange',
                    'yellow',
                    'lightgreen',
                    'green',
                    '#006400'
                ]
            }]
        };

        new Chart(ctxBarras, {
            type: 'bar',
            data: datosBarras,
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
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
            }
        });
    </script>
</body>
</html>
