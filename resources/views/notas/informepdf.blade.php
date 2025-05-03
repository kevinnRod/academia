<!DOCTYPE html>
<html>
<head>
    <title>Notas de Alumnos</title>
    <style>
        .{
            font-size: 18px;
        }
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
            text-align: center;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .no-border.th222 {
        border: none;
        background-color: transparent;
    }

    /* Estilo para la columna "Promedio Trimestre" */
    .promedio-trimestre {
        background-color: #FFEEAA; /* Amarillo pastel */
    }

    /* Estilo para la columna "Promedio Final" */
    .promedio-final {
        background-color: #aaffd5; /* Color de tu elección */
    }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Informe de Notas por Trimestre</h1>
            <h2 class="title">I.E VIRÚ</h2>
            <img src="insignia.jpg" alt="Logo de la institución" width="5%" />
        </div>
        <table style="width: 100%; border: none;">
            <tr>
                <td><strong>Periodo:</strong></td>
                <td>{{ $datosTrimestres[0]['trimestre']->idperiodo }}</td>
                <td><strong>Nivel:</strong></td>
                <td>{{ $datosTrimestres[0]['alumnosNotas'][0]->curso->nivel->nivel }}</td>
                <td><strong>Código curso:</strong></td>
                <td>{{ $datosTrimestres[0]['alumnosNotas'][0]->curso->codCurso }}</td>
                <td><strong>Curso:</strong></td>
                <td>{{ $datosTrimestres[0]['alumnosNotas'][0]->curso->curso }}</td>
                
            </tr>
            <tr>
                <td><strong>Grado:</strong></td>
                <td>{{ $datosTrimestres[0]['alumnosNotas'][0]->grado->grado }}</td>
                <td><strong>Sección:</strong></td>
                <td>{{ $datosTrimestres[0]['alumnosNotas'][0]->seccion->seccion }}</td>
                <td><strong>Código docente:</strong></td>
                <td>{{ $datosTrimestres[0]['alumnosNotas'][0]->codDocente }}</td>
                <td><strong>Docente:</strong></td>
                <td>{{ $datosTrimestres[0]['alumnosNotas'][0]->docente->nombres }} {{ $datosTrimestres[0]['alumnosNotas'][0]->docente->apellidos }}</td>
            </tr>
        </table>

        <div class="container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="th222">Nro Alumno</th>
                        <th class="th222">Alumno</th>
                        @foreach ($datosTrimestres as $datosTrimestre)
                            @foreach ($datosTrimestre['capacidad'] as $capacidad)
                                <th class="th222">{{ $capacidad->descripcion }}</th>
                            @endforeach
                            <th class="th222 promedio-trimestre">
                                Promedio {{ $datosTrimestre['trimestre']->descripcion }}
                            </th>
                        @endforeach
                        <th class="th222 promedio-final">
                            Promedio Final
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $alumnosMostrados = [];
                        $contador = 1; // Inicializa una variable contador
                    @endphp
                    @foreach ($datosTrimestres[0]['alumnosNotas'] as $alumno)
                        @if (!in_array($alumno->dniAlumno, $alumnosMostrados))
                            @php
                                array_push($alumnosMostrados, $alumno->dniAlumno);
                            @endphp
                            <tr>
                                <td>{{ $contador }}</td>
                                <td>
                                    {{ $alumno->alumno->apellidos }}, {{ $alumno->alumno->nombres }}
                                </td>
                                @foreach ($datosTrimestres as $datosTrimestre)
                                    @foreach ($datosTrimestre['capacidad'] as $capacidad)
                                        <td style="color: {{ isset($datosTrimestre['alumnosPorCapacidad'][$alumno->dniAlumno][$capacidad->idcapacidad]) && $datosTrimestre['alumnosPorCapacidad'][$alumno->dniAlumno][$capacidad->idcapacidad] === 'C' ? 'red' : 'black' }}">
                                            @if (isset($datosTrimestre['alumnosPorCapacidad'][$alumno->dniAlumno]) &&
                                                isset($datosTrimestre['alumnosPorCapacidad'][$alumno->dniAlumno][$capacidad->idcapacidad]))
                                                {{ $datosTrimestre['alumnosPorCapacidad'][$alumno->dniAlumno][$capacidad->idcapacidad] }}
                                            @else
                                                
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="promedio-trimestre" style="color: {{ isset($datosTrimestre['promedioAlumno'][$alumno->dniAlumno]) && $datosTrimestre['promedioAlumno'][$alumno->dniAlumno] === 'C' ? 'red' : 'black' }}" >
                                    @if (isset($datosTrimestre['promedioAlumno'][$alumno->dniAlumno]))
                                        {{ $datosTrimestre['promedioAlumno'][$alumno->dniAlumno] }}
                                    @else
                                        
                                    @endif                                    
                                    </td>
                                @endforeach
                                <td class="promedio-final" style="color: {{ isset($promediosFinales[$alumno->dniAlumno]) && $promediosFinales[$alumno->dniAlumno] === 'C' ? 'red' : 'black' }}">
                                    @if (isset($datosTrimestre['promedioAlumno'][$alumno->dniAlumno]))
                                        {{ $promediosFinales[$alumno->dniAlumno] }}
                                    @else
                                        
                                    @endif  

                                </td>
                            </tr>
                            @php
                                $contador++; // Incrementa el contador
                            @endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
