@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Eliminar Tipo de Examen</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('tipoexamen.index') }}">Tipos de Examen</a></li>
    <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-12">
            <div class="card border-danger shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">Confirmar Eliminación</h4>
                    <div class="text-center mb-4">
                        <i class="fas fa-exclamation-circle fa-3x text-danger"></i>
                    </div>
                    <p class="text-center mb-4">Está a punto de eliminar el siguiente tipo de examen. ¿Está seguro de que desea continuar?</p>
                    <div class="row mb-4">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group">
                                <label class="form-label">ID Tipo de Examen</label>
                                <input type="text" class="form-control form-control-lg bg-light" value="{{ $tipoexamen->idtipoexamen }}" disabled>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Descripción</label>
                                <input type="text" class="form-control form-control-lg bg-light" value="{{ $tipoexamen->descripcion }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <form method="POST" action="{{ route('tipoexamen.destroy', $tipoexamen->idtipoexamen) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                            <a href="{{ route('tipoexamen.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
