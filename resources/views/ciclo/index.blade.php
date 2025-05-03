@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Ciclos</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Ciclos</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-12">
                        <h4 class="card-title">Lista de ciclos</h4>
                    </div>
                    
                    <nav class="navbar bg-body-tertiary flex">
                        <div class="container-fluid justify-content-end">
                            <div class="float-left">
                                <a href="{{ route('ciclo.create') }}" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Crear nuevo ciclo</a>
                            </div>
                            <div class="col-md-4 col-12">
                                <form class="d-flex" role="search">
                                    <input name="buscarpor" class="form-control me-2" type="search" placeholder="Búsqueda por descripción" aria-label="Search" value="{{ $buscarpor }}">
                                    <button class="btn btn-success" type="submit">Buscar</button>
                                </form>
                            </div>
                        </div>
                    </nav>

                    @if (session('datos'))
                    <div id="mensaje">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('datos') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="border-top-0">ID Ciclo</th>
                                    <th class="border-top-0">Descripción</th>
                                    <th class="border-top-0">Fecha Inicio</th>
                                    <th class="border-top-0">Fecha Término</th>
                                    <th class="border-top-0">Tipo Ciclo</th>
                                    <th class="border-top-0">Periodo</th>
                                    <th class="border-top-0">Área</th>
                                    <th class="border-top-0">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if ($ciclos->count() <= 0)
                                <tr>
                                    <td colspan="8">No hay registros</td>
                                </tr>
                            @else
                                @foreach($ciclos as $item)
                                <tr>
                                    <td>{{ $item->idciclo }}</td>
                                    <td>{{ $item->descripcion }}</td>
                                    <td>{{ $item->fechaInicio }}</td>
                                    <td>{{ $item->fechaTermino }}</td>
                                    <td>{{ $item->tipo_ciclo->descripcion }}</td>
                                    <td>{{ $item->periodo->idperiodo }}</td>
                                    <td>{{ $item->area->descripcion }}</td>
                                    <td>
                                        <a href="{{ route('ciclo.edit', $item->idciclo) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                        <a href="{{ route('ciclo.confirmar', $item->idciclo) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{ $ciclos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
