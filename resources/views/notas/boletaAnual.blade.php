<!DOCTYPE html>
<html>
<head>
    <title>Boleta de Notas Anual</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin-top: 1px; /* Ajusta el margen superior */
        margin-bottom: 1px; /* Ajusta el margen inferior */
        padding: 0;
    }
        .header {
            text-align: center;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .imagen-centro {
            display: block;
            margin: 0 auto;
            text-align: center;
        }
        .cabecera-capacidades {
            background-color: #ccc;
        }   
  
        .promedioTabla{
            font-weight: bold;
        }
    
    </style>
</head>
<body>
    <div class="header">
        <h1>Boleta de Notas - Año {{ $notasPorTrimestre[0]['trimestre']->idperiodo }}</h1>
        <h1 class="title">I.E VIRÚ</h1>
        <img src="insignia.jpg" alt="Logo de la institución" class="imagen-centro" width="20%" />
    </div>
    <div>
        <p><strong>DNI:</strong> {{ $alumno->dniAlumno }}</p>
        <p><strong>Apellidos y Nombres:</strong> {{ $alumno->apellidos }} {{ $alumno->nombres }}</p>
        <p><strong>Nivel:</strong> {{ $notasPorTrimestre[0]['notas']->first()->grado->nivel->nivel }}</p>
        <p><strong>Grado:</strong> {{ $notasPorTrimestre[0]['notas']->first()->grado->grado }}</p>
        <p><strong>Sección:</strong> {{ $notasPorTrimestre[0]['notas']->first()->seccion->seccion }}</p>


    </div>
    @foreach ($notasPorTrimestre as $trimestreData)
        <div class="container">
            <p style="font-weight: bold;">Trimestre: {{ $trimestreData['trimestre']->descripcion }}</p>

            @if ($trimestreData['notas']->isEmpty())
                <p>No hay notas disponibles para este trimestre.</p>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Capacidades</th>
                        <th>Nota Trimestre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trimestreData['notas']->groupBy('idCurso') as $cursoId => $notasPorCurso)
                        @php
                            $rowspan = count($notasPorCurso) + 2; // +1 para la fila de promedio
                        @endphp
                        <tr>
                            <td rowspan="{{ $rowspan }}">{{ $notasPorCurso->first()->curso->curso }}</td>
                            <td colspan="2" class="cabecera-capacidades"></td>
                        </tr>
                        @foreach ($notasPorCurso as $nota)
                            <tr>
                                <td>{{ $nota->capacidad->descripcion }}</td>
                                <td>{{ $nota->nota }}</td>
                            </tr>
                        @endforeach
                        <tr class="promedioTabla">
                            <td>Promedio</td>
                            <td>{{ $trimestreData['promedios'][$cursoId] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    @endforeach


    <!-- Después de las tres tablas existentes -->
<!-- Después de las tres tablas existentes -->

<div class="container">
    <h2>Resumen Anual</h2>
    @if (count($notasPorTrimestre) > 0)
    <table>
        <thead>
            <tr>
                <th>Curso</th>
                @foreach ($notasPorTrimestre as $trimestreData)
                    <th>Promedio T{{ $trimestreData['trimestre']->idtrimestre }}</th>
                @endforeach
                <th>Promedio Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notasPorTrimestre[0]['notas']->groupBy('idCurso') as $cursoId => $notasPorCurso)
                <tr>
                    <td>{{ $notasPorCurso->first()->curso->curso }}</td>
                    @foreach ($notasPorTrimestre as $trimestreData)
                        <td>{{ $trimestreData['promedios'][$cursoId] ?? '' }}</td>
                    @endforeach
                    <td>{{ $promedioFinal[$cursoId] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

</body>
</html>
