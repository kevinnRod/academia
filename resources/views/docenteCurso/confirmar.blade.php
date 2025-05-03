@extends('layouts.plantilla')

@section('contenido')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">CONFIRMAR ELIMINACIÓN</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Cerrar">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="mx-2">
                <p>¿Estás seguro de que deseas eliminar esta cátedra?</p>
                <p><strong>Código:</strong> {{ $docenteCurso->id }}</p>
                <p><strong>Periodo:</strong> {{ $docenteCurso->idperiodo }}</p>
                <p><strong>Docente:</strong> {{ $docenteCurso->docente->apellidos }} {{ $docenteCurso->docente->nombres }}</p>
                <p><strong>Curso:</strong> {{ $docenteCurso->curso->curso }}</p>
                <p><strong>Nivel:</strong> {{ $docenteCurso->grado->nivel->nivel }}</p>
                <p><strong>Grado:</strong> {{ $docenteCurso->grado->grado }}</p>
                <p><strong>Sección:</strong> {{ $docenteCurso->seccion->seccion }}</p>
            </div>
            
            <div class="row text-center">
                <div class="col-6">
                    <form method="POST" action="{{ route('docenteCurso.eliminar', ['id' => $docenteCurso->id, 'codDocente' => $docenteCurso->codDocente, 'idCurso' => $docenteCurso->idCurso, 'idperiodo' => $docenteCurso->idperiodo]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
                    </form>
                </div>
                <div class="col-6">
                    <a href="{{ route('docenteCurso.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>

                </div>
            </div>
            
        </div>
    </div>
@endsection
