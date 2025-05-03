@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Crear Cátedra</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('catedra.index') }}">Cátedras</a></li>
    <li class="breadcrumb-item active" aria-current="page">Crear Cátedra</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('catedra.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="codDocente" class="form-label">Docente</label>
                            <select class="form-select" id="codDocente" name="codDocente">
                                <option value="" selected>-- Seleccione un docente --</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->codDocente }}" {{ old('codDocente') == $docente->codDocente ? 'selected' : '' }}>
                                        {{ $docente->nombres }} {{ $docente->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                            @error('codDocente')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="idcurso" class="form-label">Curso</label>
                            <select class="form-select" id="idcurso" name="idcurso">
                                <option value="" selected>-- Seleccione un curso --</option>
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->idcurso }}" {{ old('idcurso') == $curso->idcurso ? 'selected' : '' }}>
                                        {{ $curso->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idcurso')
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
                                <label for="idarea" class="form-label">Área</label>
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
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="idaula" class="form-label">Aula</label>
                            <select class="form-select" id="idaula" name="idaula">
                                <option value="" selected>-- Seleccione un aula --</option>
                            </select>
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
                            <a href="{{ route('catedra.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
