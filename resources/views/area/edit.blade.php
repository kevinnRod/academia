@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Editar Área</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Editar Área</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('area.update', $area->idarea) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="idarea" class="form-label">ID</label>
                            <input type="text" class="form-control" id="idarea" name="idarea" value="{{ $area->idarea }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion', $area->descripcion) }}">
                            @error('descripcion')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
