@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Editar Ciclo</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item"><a href="{{ route('ciclo.index') }}">Ciclos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar Ciclo</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('ciclo.update', $ciclo->idciclo) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $ciclo->descripcion }}" required>
                        </div>
                        <div class="form-group">
                            <label for="fechaInicio">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" value="{{ $ciclo->fechaInicio }}" required>
                        </div>
                        <div class="form-group">
                            <label for="fechaTermino">Fecha Término</label>
                            <input type="date" class="form-control" id="fechaTermino" name="fechaTermino" value="{{ $ciclo->fechaTermino }}" required>
                        </div>
                        <div class="form-group">
                            <label for="idtipociclo">Tipo Ciclo</label>
                            <select class="form-control" id="idtipociclo" name="idtipociclo" required>
                                @foreach ($tiposCiclo as $tipoCiclo)
                                    <option value="{{ $tipoCiclo->idtipociclo }}" {{ $ciclo->idtipociclo == $tipoCiclo->idtipociclo ? 'selected' : '' }}>{{ $tipoCiclo->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="idperiodo">Periodo</label>
                            <select class="form-control" id="idperiodo" name="idperiodo" required>
                                @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->idperiodo }}" {{ $ciclo->idperiodo == $periodo->idperiodo ? 'selected' : '' }}>{{ $periodo->idperiodo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="idarea">Área</label>
                            <select class="form-control" id="idarea" name="idarea" required>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->idarea }}" {{ $ciclo->idarea == $area->idarea ? 'selected' : '' }}>{{ $area->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
