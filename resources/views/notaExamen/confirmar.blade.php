@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Confirmar Eliminación de Notas del Examen</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('notaExamen.index') }}">Notas de Examen</a></li>
    <li class="breadcrumb-item active" aria-current="page">Confirmar Eliminación de Notas del Examen</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card border-danger shadow-sm">
                <div class="card-body">
                    <h5>¿Está seguro de que desea eliminar todas las notas del examen "{{ $examen->descripcion }}"?</h5>
                    <form method="POST" action="{{ route('notaExamen.destroy', $examen->idexamen) }}">
                        @csrf
                        @method('DELETE')
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                            <a href="{{ route('notaExamen.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
