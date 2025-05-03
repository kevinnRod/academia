@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Confirmar Eliminación</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Confirmar Eliminación</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('ciclo.destroy', $ciclo->idciclo) }}">
                        @csrf
                        @method('DELETE')

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $ciclo->descripcion }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" value="{{ $ciclo->fechaInicio }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="fechaTermino" class="form-label">Fecha Término</label>
                            <input type="date" class="form-control" id="fechaTermino" name="fechaTermino" value="{{ $ciclo->fechaTermino }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="idtipociclo" class="form-label">Tipo de Ciclo</label>
                            <input type="text" class="form-control" id="idtipociclo" name="idtipociclo" value="{{ $ciclo->tipo_ciclo->descripcion }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="idperiodo" class="form-label">Periodo</label>
                            <input type="text" class="form-control" id="idperiodo" name="idperiodo" value="{{ $ciclo->periodo->descripcion }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="idarea" class="form-label">Área</label>
                            <input type="text" class="form-control" id="idarea" name="idarea" value="{{ $ciclo->area->descripcion }}" disabled>
                        </div>

                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        <a href="{{ route('ciclo.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
