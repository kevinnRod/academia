<!DOCTYPE html>
<html>
<head>
    <title>Boleta de Notas Trimestre</title>
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
    <div class="container">
        <div class="header">
            <h1>Boleta de Notas - Trimestre {{ $trimestre }}</h1>
            <h1 class="title">I.E VIRÚ</h1>
            <img src="insignia.jpg" alt="Logo de la institución" class="imagen-centro" width="20%" />
        </div>
        <div>
            <p><strong>Periodo:</strong> {{ $notas->first()->idperiodo}}</p>

            <p><strong>DNI:</strong> {{ $alumno->dniAlumno }}</p>
            <p><strong>Apellidos y Nombres:</strong> {{ $alumno->apellidos }} {{ $alumno->nombres }}</p>
            <p><strong>Nivel:</strong> {{ $notas->first()->grado->nivel->nivel}}</p>
            <p><strong>Grado:</strong> {{ $notas->first()->grado->grado}}</p>
            <p><strong>Seccion:</strong> {{ $notas->first()->seccion->seccion}}</p>

        </div>
        @if ($notas->isEmpty())
            <p>No hay notas disponibles para este trimestre.</p>
        @else
        <table>
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Capacidades</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notas->groupBy('idCurso') as $cursoId => $notasPorCurso)
                    @php
                        $rowspan = count($notasPorCurso) + 2; // +1 para la fila de promedio
                    @endphp
                        <tr>
                            <td rowspan="{{ $rowspan }}" >{{ $notasPorCurso->first()->curso->curso }}</td>
                            <td colspan="2" class="cabecera-capacidades" ></td>
                        </tr>
                    @foreach ($notasPorCurso as $nota)
                        <tr>
                            <td>{{ $nota->capacidad->descripcion }}</td>
                            <td>{{ $nota->nota }}</td>
                        </tr>
                    @endforeach
                        <tr class="promedioTabla">
                            <td>Promedio</td>
                            <td>{{ $promedios[$cursoId] }}</td>
                        </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</body>
</html>
