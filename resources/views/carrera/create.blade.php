@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Crear Carrera</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('carrera.index') }}">Carreras</a></li>
    <li class="breadcrumb-item active" aria-current="page">Crear Carrera</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('carrera.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion') }}">
                            @error('descripcion')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="idarea" class="form-label">Área</label>
                            <select class="form-select" id="idarea" name="idarea">
                                @foreach($areas as $area)
                                    <option value="{{ $area->idarea }}" {{ old('idarea') == $area->idarea ? 'selected' : '' }}>
                                        {{ $area->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idarea')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
