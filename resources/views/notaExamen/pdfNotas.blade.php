<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas del Alumno</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        
        /* Solo aplicar borde a las tablas con la clase 'tabla' */
        .tabla {
            border: 1px solid black;
        }
        .tabla th, .tabla td {
            border: 1px solid black;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Notas del Alumno</h1>
</div>

<div class="section-title"><h2>Datos del Estudiante</h2></div>
<table class="data-table" style="border: none;">
    <tr>
        <td>
            <table>
                <tr>
                    <th>DNI</th>
                    <td>{{ $alumno->dniAlumno }}</td>
                </tr>
                <tr>
                    <th>Nombre Completo</th>
                    <td>{{ $alumno->nombres }} {{ $alumno->apellidos }}</td>
                </tr>
                <tr>
                    <th>Fecha de nacimiento</th>
                    <td>{{ $alumno->fechaNacimiento }}</td>
                </tr>
                <tr>
                    <th>Carrera a postular</th>
                    <td>{{ $alumno->carrera->descripcion }}</td>
                </tr>
            </table>
        </td>
        <td style="vertical-align: top; text-align: right;">
            @if ($alumno->featured)
                <img src="{{ $alumno->featured }}" alt="Imagen del Alumno" style="width: 150px; height: auto; margin-left: 20px;" />
            @else
                <p>No hay imagen disponible</p>
            @endif
        </td>
    </tr>
</table>

@foreach($periodosConCiclos as $periodoData)
    <div class="section">
        <h2>Periodo: {{ $periodoData['periodo']->idperiodo }} ({{ $periodoData['periodo']->fechaInicio }} - {{ $periodoData['periodo']->fechaTermino }})</h2>
        @foreach($periodoData['ciclos'] as $cicloData)
            <h3>Ciclo: {{ $cicloData['ciclo']->descripcion }} - {{ $cicloData['ciclo']->area->descripcion }}</h3>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Fecha del Examen</th>
                        <th>Aula</th>
                        <th>Nota de Ciencias-matemática</th>
                        <th>Nota de letras</th>
                        <th>Nota Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cicloData['examenes'] as $examen)
                        @php
                            $nota = $examen->notas->first();
                        @endphp
                        <tr>
                            <td>{{ $examen->fecha }}</td>
                            <td>{{ $examen->aula->descripcion }}</td>
                            <td>{{ $nota->notaaptitud ?? '-' }}</td>
                            <td>{{ $nota->notaconocimientos ?? '-' }}</td>
                            <td>{{ $nota->notatotal ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
@endforeach

<img src="{{ public_path('images/graficos/72039178.png') }}" alt="Imagen del Alumno" style="width: 700px; height: auto;" />

</body>
</html>
