@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Cursos</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Cursos</li>
@endsection 

@section('contenido')
    <div class="row text-black">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-12">
                        <h4 class="card-title">Lista de Cursos</h4>

                    </div>

                    <nav class="navbar bg-body-tertiary">
                        <div class="container-fluid justify-content-end">
                            <div class="col">
                                <a href="{{ route('cursos.create') }}" class="btn btn-primary me-4"><i class="fas fa-plus"></i> Nuevo Curso</a>
                            </div>
                            <div class="col-md-4 col-6">
                                <form class="d-flex" role="search">
                                    <input name="buscarpor" class="form-control me-2" type="search" placeholder="Busqueda por curso" arialabel="Search" value="{{ $buscarpor }}">
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
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="border-top-0">Código</th>
                                    <th class="border-top-0">Abreviatura</th>
                                    <th class="border-top-0">Curso</th>
                                    <th class="border-top-0">Nivel</th>
                                    <th class="border-top-0">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($cursos)<=0)
                                <tr>
                                    <td colspan="3">No hay registros</td>
                                </tr>
                            @else
                                @foreach($cursos as $itemcurso) 
                                <tr>
                                    <td>{{$itemcurso->idCurso}}</td>

                                    <td>{{$itemcurso->codCurso}}</td>
                                    <td>{{$itemcurso->curso}}</td>
                                    <td>{{$itemcurso->nivel->nivel}}</td>
                                    <td>
                                        <a href="{{ route('cursos.edit', $itemcurso->idCurso) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                        <a href="{{ route('cursos.confirmar', $itemcurso->idCurso) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</a>

                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{ $cursos->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection