@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Matriculas</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Matrículas</li>
@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
            <h4 class="card-title text-center mt-4" style="font-size: 1.5rem; font-weight: bold; color: #4A4A4A;">Lista de Matrículas</h4>
                <div class="card-body">
                    

                    <nav class="navbar bg-light p-3 rounded shadow-sm">
                        <form action="{{ route('matriculas.index') }}" method="GET" class="w-100">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" name="buscarpor" class="form-control" placeholder="Buscar por DNI" value="{{ request('buscarpor') }}" aria-label="Buscar por DNI">
                                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a href="{{ route('matriculas.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Nueva Matrícula</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <select name="idperiodo" id="idperiodo" class="form-select" onchange="cargarTiposCiclo()">
                                        <option value="">-- Seleccione un periodo --</option>
                                        @foreach ($periodos as $periodo)
                                            <option value="{{ $periodo->idperiodo }}" {{ $periodo->idperiodo == $idperiodoSeleccionado ? 'selected' : '' }}>
                                                {{ $periodo->idperiodo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <select name="idtipociclo" id="idtipociclo" class="form-select" onchange="cargarAreas()">
                                        <option value="">-- Seleccione un tipo de ciclo --</option>
                                        @foreach ($tiposCiclo as $tipoCiclo)
                                            <option value="{{ $tipoCiclo->idtipociclo }}" {{ request('idtipociclo') == $tipoCiclo->idtipociclo ? 'selected' : '' }}>
                                                {{ $tipoCiclo->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <select name="idarea" id="idarea" class="form-select" onchange="cargarCiclos()">
                                        <option value="">-- Seleccione un área --</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->idarea }}" {{ request('idarea') == $area->idarea ? 'selected' : '' }}>
                                                {{ $area->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <select name="idciclo" id="idciclo" class="form-select" onchange="cargarAulas()">
                                        <option value="">-- Seleccione un ciclo --</option>
                                        @foreach ($ciclos as $ciclo)
                                            <option value="{{ $ciclo->idciclo }}" {{ request('idciclo') == $ciclo->idciclo ? 'selected' : '' }}>
                                                {{ $ciclo->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <select name="idaula" id="idaula" class="form-select">
                                        <option value="">-- Seleccione un aula --</option>
                                        @foreach ($aulas as $aula)
                                            <option value="{{ $aula->idaula }}" {{ request('idaula') == $aula->idaula ? 'selected' : '' }}>
                                                {{ $aula->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <button class="btn btn-primary" type="submit">Filtrar</button>
                                </div>
                            </div>
                        </form>
                    </nav>

                    @if (session('datos'))
                    <div id="mensaje">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('datos') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th class="border-top-0">N° Matrícula</th>
                                    <th class="border-top-0">DNI Alumno</th>
                                    <th class="border-top-0">Alumno</th>
                                    <th class="border-top-0">Fecha</th>
                                    <th class="border-top-0">Hora</th>
                                    <th class="border-top-0">Periodo</th>
                                    <th class="border-top-0">Nombre del Ciclo</th>
                                    <th class="border-top-0">Tipo de Ciclo</th>
                                    <th class="border-top-0">Área del Ciclo</th>
                                    <th class="border-top-0">Aula</th>
                                    <th class="border-top-0">Foto</th>
                                    <th class="border-top-0">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($matriculas) <= 0)
                                <tr>
                                    <td colspan="11">No hay registros</td>
                                </tr>
                            @else
                                @foreach($matriculas as $itemMatricula)
                                <tr class="text-center">
                                    <td>{{ $itemMatricula->numMatricula }}</td>
                                    <td>{{ $itemMatricula->dniAlumno }}</td>
                                    <td>{{ $itemMatricula->nombres }} {{ $itemMatricula->apellidos }}</td>
                                    <td>{{ $itemMatricula->fechaMatricula }}</td>
                                    <td>{{ $itemMatricula->horaMatricula }}</td>
                                    <td>{{ $itemMatricula->idperiodo}}</td>
                                    <td>{{ $itemMatricula->ciclo_descripcion}}</td>
                                    <td>{{ $itemMatricula->tipo_ciclo_descripcion }}</td>
                                    <td>{{ $itemMatricula->area_descripcion }}</td>
                                    <td>{{ $itemMatricula->aula_descripcion }}</td>
                                    <td>
                                        @if ($itemMatricula->urlTemporal)
                                            <a href="{{ $itemMatricula->urlTemporal }}" data-fancybox="gallery" data-caption="Foto del alumno">
                                                <img src="{{ $itemMatricula->urlTemporal }}" alt="Foto del alumno" class="img-fluid" width="100px">
                                            </a>
                                        @else
                                            <span>Sin foto</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <a href="{{ route('matriculas.ficha.pdf', $itemMatricula->numMatricula) }}" target="_blank" class="btn btn-danger btn-sm">
                                            <i class="fas fa-print"></i> Imprimir
                                        </a>
                                        <a href="{{ route('matriculas.edit', $itemMatricula->numMatricula) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                        <a href="{{ route('matriculas.confirmar', $itemMatricula->numMatricula) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{ $matriculas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
