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
                    <form method="POST" action="{{ route('aula.destroy', $aula->idaula) }}">
                        @csrf
                        @method('DELETE')
                        
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $aula->descripcion }}" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label for="idciclo" class="form-label">Ciclo</label>
                            <input type="text" class="form-control" id="idciclo" name="idciclo" value="{{ $aula->ciclo->descripcion }}" disabled>
                        </div>

                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        <a href="{{ route('aula.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
