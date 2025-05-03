<!-- resources/views/matriculas/confirmar.blade.php -->

@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Eliminar Matrícula</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('matriculas.index') }}">Matrículas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
@endsection

@section('contenido')
    <!-- DATOS MATRICULA -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title text-primary">Datos de la Matrícula</h4>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Número de Matrícula</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control-plaintext" value="{{ $matricula->numMatricula }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Año Escolar</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control-plaintext" value="{{ $matricula->ciclo->periodo->anio }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Fecha de Inicio</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control-plaintext" value="{{ $matricula->ciclo->periodo->fechaInicio }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Fecha de Término</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control-plaintext" value="{{ $matricula->ciclo->periodo->fechaTermino }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Tipo de Ciclo</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control-plaintext" value="{{ $matricula->ciclo->tipo_ciclo->descripcion }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Área</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control-plaintext" value="{{ $matricula->ciclo->area->descripcion }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Ciclo</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control-plaintext" value="{{ $matricula->ciclo->descripcion }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Aula</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control-plaintext" value="{{ $matricula->aula->descripcion }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DATOS ALUMNO -->
    <div class="row mt-4">
        <div class="col-sm-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title text-primary">Datos del Alumno</h4>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">DNI</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control-plaintext" value="{{ $matricula->alumno->dniAlumno }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Apellidos</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control-plaintext" value="{{ $matricula->alumno->apellidos }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Nombres</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control-plaintext" value="{{ $matricula->alumno->nombres }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Fecha de Nacimiento</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control-plaintext" value="{{ $matricula->alumno->fechaNacimiento }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Carrera</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control-plaintext" value="{{ $matricula->alumno->carrera }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Foto del Alumno</label>
                        <div class="col-md-8">
                            <a href="{{ asset($matricula->alumno->featured) }}" data-fancybox="gallery" data-caption="Foto del alumno">
                                <img src="{{ asset($matricula->alumno->featured) }}" alt="Foto del alumno" class="img-fluid rounded-circle" width="120px">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONFIRMAR ELIMINACIÓN -->
    <div class="row mt-4">
        <div class="col-sm-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <form method="POST" action="{{ route('matriculas.destroy', $matricula->numMatricula) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg">Confirmar Eliminación</button>
                        <a href="{{ route('matriculas.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
