@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Tipos de Examen</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Tipos de Examen</li>
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <form method="GET" action="{{ route('tipoexamen.index') }}">
                            <input type="text" name="buscarpor" value="{{ $buscarpor }}" placeholder="Buscar..." class="form-control">
                        </form>
                        <a href="{{ route('tipoexamen.create') }}" class="btn btn-primary">Nuevo Tipo de Examen</a>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tipoexamenes as $tipoexamen)
                                <tr>
                                    <td>{{ $tipoexamen->idtipoexamen }}</td>
                                    <td>{{ $tipoexamen->descripcion }}</td>
                                    <td>{{ $tipoexamen->estado ? 'Activo' : 'Inactivo' }}</td>
                                    <td>
                                        <a href="{{ route('tipoexamen.edit', $tipoexamen->idtipoexamen) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="{{ route('tipoexamen.confirmar', $tipoexamen->idtipoexamen) }}" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $tipoexamenes->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
