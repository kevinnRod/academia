@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Crear Examen</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('notaExamen.index') }}">Exámenes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Crear Examen</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('notaExamen.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion') }}">
                            @error('descripcion')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ old('fecha') }}">
                            @error('fecha')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="idperiodo" class="form-label">Periodo</label>
                                <select class="form-select" id="idperiodo" name="idperiodo" onchange="cargarTiposCiclo()">
                                    <option value="" selected>--Periodo--</option>
                                    @foreach ($periodos as $periodo)
                                        <option value="{{ $periodo->idperiodo }}" {{ $idperiodoSeleccionado == $periodo->idperiodo ? 'selected' : '' }}>
                                            {{ $periodo->idperiodo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="idtipociclo" class="form-label">Tipo de Ciclo</label>
                                <select class="form-select" id="idtipociclo" name="idtipociclo" onchange="cargarAreas()">
                                    <option value="" selected>-- Seleccione un tipo de ciclo --</option>
                                    @foreach ($tiposCiclo as $tipo)
                                        <option value="{{ $tipo->idtipociclo }}">{{ $tipo->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="idtipociclo" class="form-label">Tipo de Ciclo</label>
                                <select class="form-select" id="idarea" name="idarea" onchange="cargarCiclos()">
                                    <option value="" selected>-- Seleccione un área --</option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->idarea }}">{{ $area->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="idciclo" class="form-label">Ciclo</label>
                                <select class="form-select" id="idciclo" name="idciclo" onchange="cargarAulas()">
                                    <option value="" selected>-- Seleccione un ciclo --</option>
                                    @foreach ($ciclos as $ciclo)
                                        <option value="{{ $ciclo->idciclo }}">{{ $ciclo->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="idaula" class="form-label">Aula</label>
                            <select name="idaula" id="idaula" class="form-select">
                                <option value="">-- Seleccione un aula --</option>
                                @foreach ($aulas as $aula)
                                    <option value="{{ $aula->idaula }}">
                                        {{ $aula->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="idtipoexamen" class="form-label">Tipo de Examen</label>
                            <select class="form-select" id="idtipoexamen" name="idtipoexamen">
                                <option value="" selected>-- Seleccione un tipo de examen --</option>
                                @foreach ($tiposExamen as $tipoExamen)
                                    <option value="{{ $tipoExamen->idtipoexamen }}">{{ $tipoExamen->descripcion }}</option>
                                @endforeach
                            </select>
                            @error('idtipoexamen')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        

                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{ route('notaExamen.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
