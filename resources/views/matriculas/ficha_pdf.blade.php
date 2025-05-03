<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Matrícula</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .section-title { font-size: 16px; margin-top: 20px; border-bottom: 1px solid #000; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .data-table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ficha de Matrícula</h1>
    </div>

    <div class="section-title">Datos del Estudiante</div>
    <table class="data-table">
        <tr>
            <th>DNI</th>
            <td>{{ $matricula->alumno->dniAlumno }}</td>
        </tr>
        <tr>
            <th>Nombre Completo</th>
            <td>{{ $matricula->alumno->nombres }} {{ $matricula->alumno->apellidos }}</td>
        </tr>
        <tr>
            <th>Fecha de nacimiento</th>
            <td>{{ $matricula->alumno->fechaNacimiento }}</td>
        </tr>
        <tr>
            <th>Carrera a postular</th>
            <td>{{ $matricula->alumno->carrera->descripcion }}</td>
        </tr>
        <tr>
            <th>Foto</th>
            <td>
            @if ($matricula->alumno->featured)
                <img src="{{ $matricula->alumno->featured }}" alt="Imagen del Alumno" style="width: 150px; height: auto;" />
            @else
                <p>No hay imagen disponible</p>
            @endif
            </td>
        </tr>
    </table>

    <div class="section-title">Datos de la Matrícula</div>
    <table class="data-table">
        <tr>
            <th>Número de Matrícula</th>
            <td>{{ $matricula->numMatricula }}</td>
        </tr>
        <tr>
            <th>Fecha de Matrícula</th>
            <td>{{ $matricula->fechaMatricula }}</td>
        </tr>
        <tr>
            <th>Hora de Matrícula</th>
            <td>{{ $matricula->horaMatricula }}</td>
        </tr>
        <tr>
            <th>Periodo</th>
            <td>{{ $matricula->ciclo->idperiodo }}</td>
        </tr>
        <tr>
            <th>Tipo de ciclo</th>
            <td>{{ $matricula->ciclo->tipo_ciclo->descripcion }}</td>
        </tr>
        <tr>
            <th>Área</th>
            <td>{{ $matricula->ciclo->area->descripcion }}</td>
        </tr>
        <tr>
            <th>Ciclo</th>
            <td>{{ $matricula->ciclo->descripcion }}</td>
        </tr>
        <tr>
            <th>Aula</th>
            <td>{{ $matricula->aula->descripcion }}</td>
        </tr>
    </table>

    <div class="section-title">Docentes del aula</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Curso</th>
                <th>Docente</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matricula->aula->catedras as $catedra)
                <tr>
                    <td>{{ $catedra->curso->descripcion }}</td>
                    <td>{{ $catedra->docente->nombres }} {{ $catedra->docente->apellidos }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Horario</div>
    <br>
            @if ($matricula->aula->rutaHorario)
                <img src="{{ $matricula->aula->rutaHorario }}" alt="Imagen del Alumno" style="width: 700px; height: auto;" />
            @else
                <p>No hay horario disponible</p>
            @endif
         


</body>
</html>
