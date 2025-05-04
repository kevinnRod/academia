@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Respuestas Correctas - {{ $examen->descripcion }}</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item"><a href="{{ route('examen.index') }}">Exámenes</a></li>
    <li class="breadcrumb-item active">Respuestas Correctas</li>
@endsection

@section('contenido')
    <div class="card border-primary shadow-sm">
        <div class="card-body">

            <form action="{{ route('respuestas_correctas.updatePorExamen', $examen->idexamen) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>N° Pregunta</th>
                                <th>Alternativa Correcta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= 100; $i++) {{-- ajusta el número de preguntas según lo necesario --}}
                                @php
                                    $respuesta = $respuestas->firstWhere('numero_pregunta', $i);
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>
                                        <select name="respuestas[{{ $i }}]" class="form-select">
                                            <option value="">-- Seleccione --</option>
                                            @foreach (['a', 'b', 'c', 'd', 'e'] as $opcion)
                                                <option value="{{ $opcion }}" {{ $respuesta && $respuesta->alternativa_correcta == $opcion ? 'selected' : '' }}>
                                                    {{ strtoupper($opcion) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Guardar Respuestas</button>
                    <a href="{{ route('examen.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
