@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Notas del Alumno en el Aula</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('notaExamen.index') }}">Notas de Examen</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ver Notas en el Aula</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="mb-3">Datos del Alumno</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>DNI:</strong> {{ $alumno->dniAlumno }}</p>
                                <p><strong>Estudiante:</strong> {{ $alumno->nombres }} {{ $alumno->apellidos }}</p>
                                <p><strong>Fecha de Nacimiento:</strong> {{ $alumno->fechaNacimiento }}</p>
                                <p><strong>Carrera:</strong> {{ $alumno->carrera->descripcion }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Foto:</strong></p>
                                <a href="{{ asset($alumno->featured) }}" data-fancybox="gallery" data-caption="Foto del alumno">
                                    <img src="{{ asset($alumno->featured) }}" alt="Foto del alumno" class="img-fluid rounded" width="150px">
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="mb-3">Periodo: {{ $aula->ciclo->periodo->idperiodo }}</h4>
                        <h4 class="mb-3">Ciclo: {{$aula->ciclo->descripcion }}</h4>
                        <h4 class="mb-3">Notas en el Aula: {{ $aula->descripcion }}</h4>
                        
                        <div class="row mb-2">
                                        <div class="col-md-6">
                                            <p><strong>Fecha Inicio:</strong> {{$aula->ciclo->fechaInicio}}</p>
                                            <p><strong>Fecha Término:</strong> {{ $aula->ciclo->fechaTermino }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Área:</strong> {{ $aula->ciclo->area->descripcion }}</p>
                                            <p><strong>Tipo:</strong> {{ $aula->ciclo->tipo_ciclo->descripcion }}</p>
                                        </div>
                                    </div>
                        @if ($examenes->isEmpty())
                            <div class="alert alert-info">
                                No se encontraron exámenes para el alumno en el aula seleccionada.
                            </div>
                        @else
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Descripción</th>
                                        <th>Nota Aptitud</th>
                                        <th>Nota Conocimientos</th>
                                        <th>Nota Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($examenes as $examen)
                                        @php
                                            $nota = $examen->notas->firstWhere('matricula.dniAlumno', $alumno->dniAlumno);
                                        @endphp
                                        <tr>
                                            <td>{{ $examen->fecha }}</td>
                                            <td>{{ $examen->descripcion }}</td>
                                            <td>{{ $nota->notaaptitud ?? 'N/A' }}</td>
                                            <td>{{ $nota->notaconocimientos ?? 'N/A' }}</td>
                                            <td>{{ $nota->notatotal ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
