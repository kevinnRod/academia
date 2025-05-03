@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">VER NOTAS</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">VER NOTAS</li>
@endsection 

@section('contenido')
    <div class="row text-black">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-12">
                        <h4 class="card-title">Lista de Notas registradas</h4>

                    </div>

                    <nav class="navbar bg-body-tertiary">
                        <div class="container-fluid justify-content-end">
                            <div class="col-md-4 col-6">
                                <form class="d-flex" role="search">
                                    <input name="buscarpor" class="form-control me-2" type="search" placeholder="Busqueda por curso" arialabel="Search" value="{{ $buscarpor }}">
                                    <button class="btn btn-success" type="submit">Buscar</button>
                                </form>
                            </div>
                        </div>
                    </nav>

                    @if (session('datos'))
                    <div id="mensaje">
                        @if (session('datos'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert" >
                            {{ session('datos') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" arialabel="Close"></button>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="border-top-0">Código</th>
                                    <th class="border-top-0">Periodo</th>
                                    <th class="border-top-0">Alumno</th>
                                    <th class="border-top-0">Curso</th>
                                    <th class="border-top-0">Capacidad</th>
                                    <th class="border-top-0">Nivel</th>
                                    <th class="border-top-0">Grado</th>
                                    <th class="border-top-0">Sección</th>
                                    <th class="border-top-0">Nota</th>
                                    <th class="border-top-0">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($notas)<=0)
                                <tr>
                                    <td colspan="3">No hay registros</td>
                                </tr>
                            @else
                                @foreach($notas as $itemnotas) 
                                <tr>
                                    <td>{{$itemnotas->idnotaTrimestre}}</td>
                                    <td>{{$itemnotas->idperiodo}}</td>
                                    <td>{{$itemnotas->alumno->nombres}} {{$itemnotas->alumno->apellidos}}</td>
                                    <td>{{$itemnotas->curso->curso}}</td>
                                    <td>{{$itemnotas->capacidad->descripcion}}</td>
                                    <td>{{$itemnotas->curso->nivel->nivel}}</td>
                                    <td>{{$itemnotas->grado->grado}}</td>
                                    <td>{{$itemnotas->seccion->seccion}}</td>
                                    <td>{{$itemnotas->nota}}</td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{ $notas->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


public function ver(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        $notas = Nota::whereHas('curso', function ($query) use ($buscarpor) {
            $query->where('curso', 'like', '%' . $buscarpor . '%');
        })
        ->orderBy('idperiodo')
        ->orderBy('idCurso')
        ->orderBy('idGrado')
        ->orderBy('idSeccion')
        ->paginate($this::PAGINATION);

        return view('notas.ver', compact('notas', 'buscarpor'));
    }












    @extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">VER NOTAS</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">VER NOTAS</li>
@endsection 

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-12">
                        <h4 class="card-title">Lista de Notas registradas</h4>
                    </div>

                    <nav class="navbar bg-body-tertiary">
                        <div class="container-fluid justify-content-end">
                            <div class="col-md-4 col-6">
                                <form class="d-flex" role="search">
                                    <input name="buscarpor" class="form-control me-2" type="search" placeholder="Busqueda por curso" aria-label="Search" value="{{ $buscarpor }}">
                                    <button class="btn btn-success" type="submit">Buscar</button>
                                </form>
                            </div>
                        </div>
                    </nav>

                    @if (session('datos'))
                        <div id="mensaje">
                            @if (session('datos'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ session('datos') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                        </div>
                    @endif

                    @if ($gruposDeNotas->isEmpty())
                        <div class="col-12">
                            <p>No hay registros</p>
                        </div>
                    @else
                        @foreach ($gruposDeNotas as $grupo)
                            @php
                                $primerNota = $grupo->first(); // Obtiene la primera nota del grupo
                            @endphp
                            <div class="col-12">
                                <p>Periodo: {{ $primerNota->idperiodo}}</p>
                                <p>Curso: {{ $primerNota->curso->curso }}</p>
                                <p>Grado: {{ $primerNota->grado->grado }}</p>
                                <p>Sección: {{ $primerNota->seccion->seccion }}</p>
                                <!-- Agrega aquí el botón "Editar" que lleva a la vista de edición -->
                            </div>
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="border-top-0">Alumno</th>
                                        <th class="border-top-0">Capacidad</th>
                                        <th class="border-top-0">Nota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grupo as $nota)
                                        <tr>
                                            <td>{{ $nota->alumno->nombres }} {{ $nota->alumno->apellidos }}</td>
                                            <td>{{ $nota->capacidad->descripcion }}</td>
                                            <td>{{ $nota->nota }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


public function ver(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
    
        $notas = Nota::with(['periodo', 'curso', 'grado', 'seccion'])
            ->whereHas('curso', function ($query) use ($buscarpor) {
                $query->where('curso', 'like', '%' . $buscarpor . '%');
            })
            ->orderBy('idperiodo')
            ->orderBy('idCurso')
            ->orderBy('idGrado')
            ->orderBy('idSeccion')
            ->get();  // Recupera todas las notas sin paginación
    
        // Agrupa las notas por periodo, curso, grado y sección
        $gruposDeNotas = $notas->groupBy(function($item) {
            return $item->periodo->idperiodo . '-' . $item->curso->idCurso . '-' . $item->grado->idGrado . '-' . $item->seccion->idSeccion;
        });
    
        return view('notas.ver', compact('gruposDeNotas', 'buscarpor'));
    }






//7aadasddddddddddddddddd

    @extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Notas de Alumnos</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item">
        <a href="{{ route('notas.index') }}">Ver Notas</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Notas de Alumnos</li>
</ul>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-12">
                        <h4 class="card-title">Notas de Alumnos</h4>
                    </div>
                   <div class="col-12">
                    <form class="form-inline my-2 my-lg-0 float-right" role="search">
                            <input name="nombreApellido" class="form-control me-2" type="search" placeholder="Buscar por nombre o apellido" aria-label="Search" value="{{ $nombreApellido }}">
                            <button class="btn btn-success" type="submit">Buscar</button>
                        </form>
                   </div>
                    
                   
                    

                    @if (session('datos'))
                    <div id="mensaje">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert" >
                            {{ session('datos') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="border-top-0">DNI Alumno</th>
                                    <th class="border-top-0">Alumno</th>
                                    <th class="border-top-0">Capacidad</th>
                                    <th class="border-top-0">Nota</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if ($alumnosNotas->isEmpty())
                                <tr>
                                    <td colspan="3">No hay registros</td>
                                </tr>
                            @else
                               
                            <div class="row">
                                <div class="col-4 form-group">
                                    <label class="col-md-12 mb-0">Trimestre:</label>
                                    <div class="col-md-12">
                                        
                                    <input type="text" class="form-control" value="{{ $alumnosNotas->first()->trimestre->descripcion }}" disabled>
                                    </div>
                                </div>
                                <div class="col-4 form-group">
                                    <label class="col-md-12 mb-0">Periodo:</label>
                                    <div class="col-md-12">
                                        
                                        <input type="text" class="form-control" value="{{ $alumnosNotas->first()->idperiodo }}" disabled>
                                    </div>
                                </div>
                                <div class="col-4 form-group">
                                    <label class="col-md-12 mb-0">Nivel:</label>
                                    <div class="col-md-12">
                                        
                                    <input type="text" class="form-control" value="{{ $alumnosNotas->first()->curso->nivel->nivel }}" disabled>
                                    </div>
                                </div>
                                <div class="col-4 form-group">
                                    <label class="col-md-12 mb-0">Curso:</label>
                                    <div class="col-md-12">
                                        
                                    <input type="text" class="form-control" value="{{ $alumnosNotas->first()->curso->curso }}" disabled>

                                    </div>
                                </div>
                                <div class="col-4 form-group">
                                    <label class="col-md-12 mb-0">Grado:</label>
                                    <div class="col-md-12">
                                        
                                    <input type="text" class="form-control" value="{{ $alumnosNotas->first()->grado->grado }}" disabled>
                                    </div>
                                </div>
                                <div class="col-4 form-group">
                                    <label class="col-md-12 mb-0">Sección:</label>
                                    <div class="col-md-12">
                                        
                                    <input type="text" class="form-control" value="{{ $alumnosNotas->first()->seccion->seccion }}" disabled>
                                    </div>
                                </div>
                                <div class="col-4 form-group">
                                    <label class="col-md-12 mb-0">Docente:</label>
                                    <div class="col-md-12">
                                        
                                    <input type="text" class="form-control" value="{{ $alumnosNotas->first()->docente->nombres }} {{ $alumnosNotas->first()->docente->apellidos }}" disabled>

                                    </div>
                                </div>              
                            </div>
                                    
                                
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                              
                                    

                                @foreach ($alumnosNotas as $alumnoNota)
                                <tr>
                                
                                    <td>{{ $alumnoNota->alumno->dniAlumno }}</td>
                                    <td>{{ $alumnoNota->alumno->nombres }} {{ $alumnoNota->alumno->apellidos }}</td>
                                    <td>{{ $alumnoNota->capacidad->descripcion}}</td>
                                    <td>{{ $alumnoNota->nota }}</td>
                                    <td>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
                <div class="col-12">
                    <a href="javascript:history.back()" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
        </div>
    </div>
@endsection











-------------------




@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Notas de Alumnos</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item">
        <a href="{{ route('notas.index') }}">Ver Notas</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Notas de Alumnos</li>
</ul>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-12">
                        <h4 class="card-title">Notas de Alumnos</h4>
                    </div>
                   <div class="col-12">
                    <form class="form-inline my-2 my-lg-0 float-right" role="search">
                            <input name="nombreApellido" class="form-control me-2" type="search" placeholder="Buscar por nombre o apellido" aria-label="Search" value="{{ $nombreApellido }}">
                            <button class="btn btn-success" type="submit">Buscar</button>
                        </form>
                   </div>
                    
                    @if (session('datos'))
                    <div id="mensaje">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert" >
                            {{ session('datos') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Trimestre:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->trimestre->descripcion }}" disabled>
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Periodo:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->idperiodo }}" disabled>
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Nivel:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->curso->nivel->nivel }}" disabled>
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Curso:</label>
                            <div class ="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->curso->curso }}" disabled>
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Grado:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->grado->grado }}" disabled>
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Sección:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->seccion->seccion }}" disabled>
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Docente:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->docente->nombres }} {{ $alumnosNotas->first()->docente->apellidos }}" disabled>
                            </div>
                        </div>      
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Docente:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->nota }}" disabled>
                            </div>
                        </div>      
     
                    </div>
                    <div class="row">
                        <div class="col p-3">
                            <button class="btn btn-primary" id="colocarNotasBtn" onclick="habilitarCampos()">Colocar notas</button>
                            <button class="btn btn-danger" id="deshabilitarEdicionBtn" onclick="deshabilitarCampos()" style="display: none;">Deshabilitar edición</button>
                        </div>
                    </div>

                    <table class="table user-table">
                        <thead>
                            <tr>
                                <th class="border-top-0">Nro</th>
                                <th class="border-top-0">Alumno</th>
                                @foreach ($capacidad as $itemCapacidad)
                                    <th class="border-top-0">{{ $itemCapacidad->descripcion }}</th>
                                @endforeach
                                <th class="border-top-0">Promedio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($gruposDeNotas->isEmpty())
                                <tr>
                                    <td colspan="{{ count($capacidad) + 2 }}">No hay registros</td>
                                </tr>
                            @else
                            @foreach ($gruposDeNotas as $itemAlumno)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @php
                                        $primerAlumno = $itemAlumno->first();
                                    @endphp
                                    <td>
                                        {{ $primerAlumno->alumno->apellidos }}, {{ $primerAlumno->alumno->nombres }}
                                    </td>
                                    @foreach ($capacidad as $itemCapacidad)
                                        <td>
                                            <select class="form-select trimestre-select capacidad-select" disabled
                                                data-idcapacidad="{{ $itemCapacidad->idcapacidad }}"
                                                data-dni="{{ $primerAlumno->dniAlumno }}"
                                                name="notas[{{ $primerAlumno->dniAlumno }}][{{ $itemCapacidad->idcapacidad }}]" >
                                                <option value=""></option>
                                                <option value="AD" @if ($primerAlumno->nota == 'AD') selected @endif>AD</option>
                                                <option value="A" @if ($primerAlumno->nota == 'A') selected @endif>A</option>
                                                <option value="B" @if ($primerAlumno->nota == 'B') selected @endif>B</option>
                                                <option value="C" @if ($primerAlumno->nota == 'C') selected @endif>C</option>
                                            </select>
                                        </td>
                                    @endforeach
                                    <td>
                                        <!-- Campo para mostrar el promedio calculado -->
                                        <input class="form-control" name="promedio" min="0" max="20" size="2" readonly>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
@endsection









public function verAlumnosPorFiltros($periodo, $curso, $grado, $seccion, $trimestre)
{
    // Obtén el valor del campo de búsqueda
    $nombreApellido = request('nombreApellido');

    // Obtén las capacidades para el curso específico
    $capacidad = Capacidad::where('idCurso', '=', $curso)->get();

    // Obtén los datos de los alumnos y sus notas
    $alumnosNotas = Nota::where('idperiodo', $periodo)
        ->where('idCurso', $curso)
        ->where('idGrado', $grado)
        ->where('idSeccion', $seccion)
        ->where('idTrimestre', $trimestre)
        ->whereHas('alumno', function ($query) use ($nombreApellido) {
            $query->where('nombres', 'like', '%' . $nombreApellido . '%')
                ->orWhere('apellidos', 'like', '%' . $nombreApellido . '%');
        })
        ->with(['curso', 'grado', 'seccion', 'docente', 'trimestre'])
        ->get();

    $gruposDeNotas = $alumnosNotas->groupBy('alumno.dniAlumno');

    return view('notas.verAlumnos', compact('alumnosNotas', 'nombreApellido', 'capacidad', 'gruposDeNotas'));
}







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
                <td><strong>Curso:</strong></td>
                <td>{{ $datosTrimestres[0]['alumnosNotas'][0]->curso->curso }}</td>
            </tr>
            <tr>
                <td><strong>Grado:</strong></td>
                <td>{{ $datosTrimestres[0]['alumnosNotas'][0]->grado->grado }}</td>
                <td><strong>Sección:</strong></td>
                <td>{{ $datosTrimestres[0]['alumnosNotas'][0]->seccion->seccion }}</td>
                <td><strong>Docente:</strong></td>
                <td>{{ $datosTrimestres[0]['alumnosNotas'][0]->docente->nombres }} {{ $datosTrimestres[0]['alumnosNotas'][0]->docente->apellidos }}</td>
            </tr>
        </table>

        <div class="container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        @foreach ($datosTrimestres as $datosTrimestre)
                            <th class="th222 no-border">{{ $datosTrimestre['trimestre']->descripcion }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($datosTrimestres as $datosTrimestre)
                            <td>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nro Alumno</th>
                                            <th>Alumno</th>
                                            @foreach ($datosTrimestre['capacidad'] as $capacidad)
                                                <th>{{ $capacidad->descripcion }}</th>
                                            @endforeach
                                            <th>Promedio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $alumnosMostrados = [];
                                            $contador = 1; // Inicializa una variable contador
                                        @endphp
                                        @foreach ($datosTrimestre['alumnosNotas'] as $alumno)
                                            @if (!in_array($alumno->dniAlumno, $alumnosMostrados))
                                                @php
                                                    array_push($alumnosMostrados, $alumno->dniAlumno);
                                                @endphp
                                                <tr>
                                                    <td>{{ $contador }}</td> <!-- Usa la variable contador en lugar de $loop->iteration -->
                                                    <td>
                                                        {{ $alumno->alumno->apellidos }}, {{ $alumno->alumno->nombres }}
                                                    </td>
                                                    @foreach ($datosTrimestre['capacidad'] as $capacidad)
                                                        <td>
                                                            {{ $datosTrimestre['alumnosPorCapacidad'][$alumno->dniAlumno][$capacidad->idcapacidad] }}
                                                        </td>
                                                    @endforeach
                                                    <td>
                                                        {{ $datosTrimestre['promedioAlumno'][$alumno->dniAlumno] }}
                                                    </td>
                                                </tr>
                                                @php
                                                    $contador++; // Incrementa el contador
                                                @endphp
                                            @endif
                                        @endforeach
                                    </tbody>


                                </table>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
