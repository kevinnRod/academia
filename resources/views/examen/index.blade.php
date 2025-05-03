@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Listado de Exámenes</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('examen.index') }}">Exámenes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Listado</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('examen.index') }}" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" name="buscarpor" class="form-control" placeholder="Buscar por descripción" value="{{ request('buscarpor') }}">
                                    <button class="btn btn-primary" type="submit">Buscar</button>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                    <select name="idperiodo" id="idperiodo" class="form-select" onchange="cargarTiposCiclo()">
                                        <option value="">-- Seleccione un periodo --</option>
                                        @foreach ($periodos as $periodo)
                                            <option value="{{ $periodo->idperiodo }}" {{ $periodo->idperiodo == $idperiodoSeleccionado ? 'selected' : '' }}>
                                                {{ $periodo->idperiodo }}
                                            </option>
                                        @endforeach
                                    </select>

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select name="idtipociclo" id="idtipociclo" class="form-select" onchange="cargarAreas()">
                                            <option value="">-- Seleccione un tipo de ciclo --</option>
                                            @foreach ($tiposCiclo as $tipoCiclo)
                                                <option value="{{ $tipoCiclo->idtipociclo }}" {{ request('idtipociclo') == $tipoCiclo->idtipociclo ? 'selected' : '' }}>
                                                    {{ $tipoCiclo->descripcion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select name="idarea" id="idarea" class="form-select" onchange="cargarCiclos()">
                                            <option value="">-- Seleccione un área --</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->idarea }}" {{ request('idarea') == $area->idarea ? 'selected' : '' }}>
                                                    {{ $area->descripcion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
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
                                <div class="mb-3">
                                    <select name="idtipoexamen" id="idtipoexamen" class="form-select">
                                        <option value="">-- Seleccione un tipo de examen --</option>
                                        @foreach ($tiposExamen as $tipoExamen)
                                            <option value="{{ $tipoExamen->idtipoexamen }}" {{ request('idtipoexamen') == $tipoExamen->idtipoexamen ? 'selected' : '' }}>
                                                {{ $tipoExamen->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mb-3">
                                    <select name="idaula" id="idaula" class="form-select">
                                        <option value="">-- Seleccione un aula --</option>
                                        @foreach ($aulas as $aula)
                                            <option value="{{ $aula->idaula }}" {{ request('idaula') == $aula->idaula ? 'selected' : '' }}>
                                                {{ $aula->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-primary" type="submit">Filtrar</button>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('examen.create') }}" class="btn btn-primary">Crear Examen</a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Periodo</th>
                                <th>Tipo ciclo</th>
                                <th>Área</th>
                                <th>Ciclo</th>
                                <th>Aula</th>
                                <th>Fecha</th>
                                <th>Tipo de Examen</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($examenes as $examen)
                                <tr>
                                    <td>{{ $examen->descripcion }}</td>
                                    <td>{{ $examen->aula->ciclo->idperiodo }}</td>
                                    <td>{{ $examen->aula->ciclo->tipo_ciclo->descripcion }}</td>
                                    <td>{{ $examen->aula->ciclo->area->descripcion }}</td>
                                    <td>{{ $examen->aula->ciclo->descripcion }}</td>
                                    <td>{{ $examen->aula->descripcion }}</td>
                                    <td>{{ $examen->fecha }}</td>
                                    <td>{{ $examen->tipo_examen->descripcion ?? 'N/A' }}</td>
                                    <td>{{ $examen->estado == 1 ? 'Activo' : 'Inactivo' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('examen.edit', $examen->idexamen) }}" class="btn btn-sm btn-primary">Editar</a>
                                        <form action="{{ route('examen.confirmar', $examen->idexamen) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('GET')
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $examenes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
