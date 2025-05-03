@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Eliminar Tipo de Ciclo</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('tipociclo.index') }}">Tipos de Ciclo</a></li>
    <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">Confirmar Eliminación</h4>
                    <div class="text-center mb-4">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                    </div>
                    <p class="text-center mb-4">Está a punto de eliminar el siguiente tipo de ciclo. ¿Está seguro de que desea continuar?</p>

                    <div class="row mb-4">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group">
                                <label class="form-label">ID Tipo Ciclo</label>
                                <input type="text" class="form-control form-control-lg bg-light" value="{{ $tipoCiclo->idtipociclo }}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Descripción</label>
                                <input type="text" class="form-control form-control-lg bg-light" value="{{ $tipoCiclo->descripcion }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <form method="POST" action="{{ route('tipociclo.destroy', $tipoCiclo->idtipociclo) }}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg me-2"><i class="fas fa-check"></i> Sí, Eliminar</button>
                            <a href="{{ route('tipociclo.index') }}" class="btn btn-secondary btn-lg"><i class="fas fa-times"></i> Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
