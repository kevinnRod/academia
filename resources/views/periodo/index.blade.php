@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Año Escolar</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Año Escolar</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-12">
                        <h4 class="card-title">Lista de periodos escolares</h4>

                    </div>
                    
                    <nav class="navbar bg-body-tertiary flex">
                        <div class="container-fluid justify-content-end">
                            <div class="float-left">
                                <a href="{{ route('periodo.create') }}" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Crear nuevo periodo</a>
                            </div>
                            <div class="col-md-4 col-12">
                                <form class="d-flex" role="search">
                                    <input name="buscarpor" class="form-control me-2" type="search" placeholder="Busqueda por año" arialabel="Search" value="{{ $buscarpor }}">
                                <button class="btn btn-success" type="submit">Buscar</button>
                                </form>
                            </div>
                        </div>
                    </nav>

                    @if (session('datos'))
                    <div id="mensaje">
                        @if (session('datos'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert" >
                            {{ session('datos') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" arialabel="Close"></button>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table ">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="border-top-0">Periodo</th>
                                    <th class="border-top-0">Fecha de Inicio</th>
                                    <th class="border-top-0">Fecha de Término</th>
                                    <th class="border-top-0">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($periodo)<=0)
                                <tr>
                                    <td colspan="3">No hay registros</td>
                                </tr>
                            @else
                                @foreach($periodo as $itemanyo) 
                                <tr>
                                    <td>{{$itemanyo->idperiodo}}</td>
                                    <td>{{$itemanyo->fechaInicio}}</td>
                                    <td>{{$itemanyo->fechaTermino}}</td>
                                    <td>
                                        <a href="{{ route('periodo.edit', $itemanyo->idperiodo) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                        <a href="{{ route('periodo.confirmar', $itemanyo->idperiodo) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{ $periodo->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection