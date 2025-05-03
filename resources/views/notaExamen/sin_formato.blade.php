<!DOCTYPE html>
<html>
<head>
    <title>Notas del Examen</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Notas del Examen: {{ $examen->descripcion }}</h2>
    
    <p>Periodo: {{ $examen->aula->ciclo->idperiodo }}</p>
    <p>Tipo de ciclo: {{ $examen->aula->ciclo->tipo_ciclo->descripcion }}</p>
    <p>Área: {{ $examen->aula->ciclo->area->descripcion }}</p>
    <p>Ciclo: {{ $examen->aula->ciclo->descripcion }}</p>
    <p>Aula: {{ $examen->aula->descripcion }}</p>
    <p>Fecha: {{ $examen->fecha }}</p>
    <p>Tipo de Examen: {{ $examen->tipo_examen->descripcion ?? 'N/A' }}</p>
    <p>Estado: {{ $examen->estado == 1 ? 'Activo' : 'Inactivo' }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Número de Matrícula</th>
                <th>Apellidos y Nombres</th>
                <th>Nota de Aptitud</th>
                <th>Nota de Conocimientos</th>
                <th>Nota Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notas as $index => $nota)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $nota->numMatricula }}</td>
                    <td>{{ $nota->matricula->alumno->apellidos }} {{ $nota->matricula->alumno->nombres }}</td>
                    <td>{{ $nota->notaaptitud }}</td>
                    <td>{{ $nota->notaconocimientos }}</td>
                    <td>{{ $nota->notatotal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
