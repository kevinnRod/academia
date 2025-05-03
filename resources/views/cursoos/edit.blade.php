@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Editar Curso</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('cursoos.index') }}">Cursos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar Curso</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('cursoos.update', $curso->idcurso) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="idcurso" class="form-label">ID Curso</label>
                            <input type="text" class="form-control" id="idcurso" name="idcurso" value="{{ $curso->idcurso }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $curso->descripcion }}">
                            @error('descripcion')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="1" {{ $curso->estado == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ $curso->estado == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
