@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Crear Aula</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Crear Aula</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('aula.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion') }}">
                            @error('descripcion')
                                <div class="alert alert-danger">{{ $message }}</div>
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
                                <select class="form-select" id="idciclo" name="idciclo">
                                    <option value="" selected>-- Seleccione un ciclo --</option>
                                    @foreach ($ciclos as $ciclo)
                                        <option value="{{ $ciclo->idciclo }}">{{ $ciclo->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Campo para la imagen del horario -->
                        <div class="mb-3">
                            <label for="rutaHorario" class="form-label">Imagen del Horario</label>
                            <input type="file" class="form-control" id="rutaHorario" name="rutaHorario">
                            @error('rutaHorario')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
