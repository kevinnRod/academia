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
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            border: none;
            padding: 10px;
        }
        .color-box {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h2>Notas del Examen: {{ $examen->descripcion }}</h2>
    
    <table class="info-table">
        <tr>
            <td>
                <p>Periodo: {{ $examen->aula->ciclo->idperiodo }}</p>
                <p>Tipo de ciclo: {{ $examen->aula->ciclo->tipo_ciclo->descripcion }}</p>
                <p>Área: {{ $examen->aula->ciclo->area->descripcion }}</p>
                <p>Ciclo: {{ $examen->aula->ciclo->descripcion }}</p>
                <p>Aula: {{ $examen->aula->descripcion }}</p>
                <p>Fecha: {{ $examen->fecha }}</p>
                <p>Tipo de Examen: {{ $examen->tipo_examen->descripcion ?? 'N/A' }}</p>
                <p>Estado: {{ $examen->estado == 1 ? 'Activo' : 'Inactivo' }}</p>
            </td>
            <td>
                <h3>Escala de Colores:</h3>
                <div><span class="color-box" style="background-color: red;"></span>0 - 50</div>
                <div><span class="color-box" style="background-color: #ff4500;"></span>51 - 100</div>
                <div><span class="color-box" style="background-color: orange;"></span>101 - 150</div>
                <div><span class="color-box" style="background-color: yellow;"></span>151 - 200</div>
                <div><span class="color-box" style="background-color: lightgreen;"></span>201 - 250</div>
                <div><span class="color-box" style="background-color: green;"></span>251 - 300</div>
                <div><span class="color-box" style="background-color: #006400;"></span>301 en adelante</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Número de Matrícula</th>
                <th>Apellidos y nombres</th>
                <th>Nota de Aptitud</th>
                <th>Nota de Conocimientos</th>
                <th>Nota Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notas as $index => $nota)
                <tr>
                    <td style="background-color: 
                        @if($nota->notatotal <= 50) red
                        @elseif($nota->notatotal <= 100) #ff4500
                        @elseif($nota->notatotal <= 150) orange
                        @elseif($nota->notatotal <= 200) yellow
                        @elseif($nota->notatotal <= 250) lightgreen
                        @elseif($nota->notatotal <= 300) green
                        @else #006400
                        @endif">
                        {{ $index + 1 }}
                    </td>
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
