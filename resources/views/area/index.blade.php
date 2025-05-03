@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Áreas</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Áreas</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <h4 class="card-title">Lista de Áreas</h4>
                        <a href="{{ route('area.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear Nueva Área</a>
                    </div>

                    <nav class="navbar bg-light mb-4">
                        <form class="d-flex w-100">
                            <input name="buscarpor" class="form-control me-2" type="search" placeholder="Buscar por descripción" aria-label="Search" value="{{ $buscarpor }}">
                            <button class="btn btn-success" type="submit">Buscar</button>
                        </form>
                    </nav>

                    @if (session('datos'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('datos') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="border-top-0">ID Área</th>
                                    <th class="border-top-0">Descripción</th>
                                    <th class="border-top-0">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($areas as $area)
                                    <tr>
                                        <td>{{ $area->idarea }}</td>
                                        <td>{{ $area->descripcion }}</td>
                                        <td>
                                            <a href="{{ route('area.edit', $area->idarea) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                            <a href="{{ route('area.confirmar', $area->idarea) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No hay registros</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $areas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
