<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ficha de Matricula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>



<body class="container">
    <div class="container-fluid">
        <div class="text-center">
            <p class="h222"><span> FICHA DE MATRÍCULA</span> </p>
            <p class="h222"><span> I.E VIRÚ</span> </p>

        </DIV>
    </div>

    <div style="text-align: right;">
        <div>Número de matrícula: {{ $matricula[0]->numMatricula }}</div>
    </div>
    <div style="text-align: right;">
        <div>Periodo: {{ $matricula[0]->idperiodo }}</div>
    </div>
    <div style="text-align: right;">
        <div>Fecha de matrícula: {{ $matricula[0]->fechaMatricula }}</div>
    </div>

    <div class="row">
        <p class="h11">Detalles del alumno</p>
        <div class="col-md-4">Codigo: {{ $alumno[0]->dniAlumno }}</div><br>
        <div class="col-md-8">Alumno: {{ $alumno[0]->apellidos}}
            {{ $alumno[0]->nombres }}
        </div><br>
        <div class="col-md-4">Edad: {{ $alumno[0]->edad }}</div><br>
        <div class="col-md-8">Fecha de Nacimiento: {{ $alumno[0]->fechaNacimiento }}</div><br>


        <hr>
    </div>
    <div class="row">
        <p class="h11">Detalles del apoderado</p>
        <div class="col-md-4">Codigo: {{ $apoderado[0]->dniApoderado }}</div><br>
        <div class="col-md-8">Alumno: {{ $apoderado[0]->apellidos}}
            {{ $apoderado[0]->nombres }}
        </div><br>
        <div class="col-md-4">Edad: {{ $apoderado[0]->edad }}</div><br>
        <div class="col-md-8">Dirección: {{ $apoderado[0]->direccion }}</div><br>
        <hr>
    </div>

    <div>
        <p class="h11">Detalles del Aula</p>
        <table class="table table-success table-striped">
            <thead>
                <tr>
                   
                    <th scope="col">Nivel</th>
                    <th scope="col">Grado</th>
                    <th scope="col">Seccion</th>
                    <th scope="col">Año Escolar</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">

                <tr>   
                <td class="border-top-2">{{ $matricula[0]->grado->nivel->nivel }}</td>
                    <td class="border-top-2">{{ $grado[0]->grado }}</td>
                    <td class="border-top-2">{{ $seccion[0]->seccion}}</td>
                    <td class="border-top-2">{{ $seccion[0]->idperiodo }}</td>
                </tr>



            </tbody>

        </table>



    </div>


    <p class="h11">Cursos</p>
    <div>

    
    <div class="m-auto">
        <table class="table table-success table-striped">
            <thead>
                <tr>
                    <th scope="col">Nro</th>
                    <th scope="col">Descripción</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach($matricula[0]->grado->nivel->cursos as $curso)
                    <tr>
                        <td>{{ $curso->idCurso }}</td>
                        <td>{{ $curso->curso }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>




    <style>

        body {
            font-family: Arial, sans-serif;
        }
        .h222{
            font-family: Arial, sans-serif;
            font-size: 20px;
            font-weight: bold;
        }
        .h11{
            font-family: Arial, sans-serif;
            font-size: 18px;
            font-weight: bold;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.07; /* Ajusta la opacidad según sea necesario */
        }
    </style>
    <img class="watermark" src="insignia.jpg" alt="Marca de Agua" width="90%"/>

</body>

</html>