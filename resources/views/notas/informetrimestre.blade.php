<!DOCTYPE html>
<html>
<head>
    <title>Notas de Alumnos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            padding: 20px;
        }
        .title {
            font-size: 24px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Notas de Alumnos</h1>
            <h1 class="title">I.E VIRÚ</h1>
            <img src="insignia.jpg" alt="Logo de la institución" width="20%" />

        </div>

        <div>
            <p><strong>Trimestre:</strong> {{ $alumnosNotas->first()->trimestre->descripcion }}</p>
            <p><strong>Periodo:</strong> {{ $alumnosNotas->first()->idperiodo }}</p>
            <p><strong>Nivel:</strong> {{ $alumnosNotas->first()->curso->nivel->nivel }}</p>
            <p><strong>Curso:</strong> {{ $alumnosNotas->first()->curso->curso }}</p>
            <p><strong>Grado:</strong> {{ $alumnosNotas->first()->grado->grado }}</p>
            <p><strong>Sección:</strong> {{ $alumnosNotas->first()->seccion->seccion }}</p>
            <p><strong>Código docente:</strong> {{ $alumnosNotas->first()->codDocente }}</p>

            <p><strong>Docente:</strong> {{ $alumnosNotas->first()->docente->nombres }} {{ $alumnosNotas->first()->docente->apellidos }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Alumno</th>
                    @foreach ($capacidad as $itemCapacidad)
                        <th>{{ $itemCapacidad->descripcion }}</th>
                    @endforeach
                    <th>Promedio</th>
                </tr>
            </thead>
            <tbody>
                @if ($alumnosNotas->isEmpty())
                    <tr>
                        <td colspan="{{ count($capacidad) + 2 }}">No hay registros</td>
                    </tr>
                @else
                @foreach ($alumnosPorCapacidad as $alumnoId => $notasPorCapacidad)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @php
                                $alumno = $alumnosNotas->where('dniAlumno', $alumnoId)->first();
                            @endphp
                            {{ $alumno->alumno->apellidos }}, {{ $alumno->alumno->nombres }}
                        </td>
                        @foreach ($capacidad as $itemCapacidad)
                            <td>
                                {{ $notasPorCapacidad[$itemCapacidad->idcapacidad] }}
                            </td>
                        @endforeach
                        <td>
                            <!-- Campo para mostrar el promedio calculado -->
                            {{ $promedioAlumno[$alumnoId] }}
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>
