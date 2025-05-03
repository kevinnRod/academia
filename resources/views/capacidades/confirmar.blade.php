
@extends('layouts.plantilla')


@section('contenido')
    <!-- Default box -->
    <div class="container">
        <h1>¿Desea eliminar esta capacidad ? </h1>
        <h2>Codigo: {{ $capacidad->idcapacidad }} </h2>
        <h2>Curso: {{ $capacidad->curso->curso }}</h2>
        <h2>Capacidad: {{ $capacidad->descripcion }}</h2>
        <div class="card-body">
            <div class="row float-right">
                <!-- Formulario -->
                <form method="POST" action="{{ route('capacidades.destroy', $capacidad->idcapacidad) }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger mx-2"><i class="fas fa-check-square"></i> SI</button>
                    <a href="{{ route('cancelarCapacidad') }}" class="btn btn-primary"><i class="fas fa-times-circle"></i> NO</a>
                </form>
            </div>
        </div>
    @endsection
    <!-- Footer -->
