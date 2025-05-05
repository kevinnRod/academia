@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Docentes</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Docentes</li>
@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Lista de docentes registrados</h4>
                    
                    <nav class="navbar bg-body-tertiary">
                        <div class="container-fluid justify-content-end">
                            <div class="col">
                                <a href="{{ route('docentes.create') }}" class="btn btn-primary me-4"><i class="fas faplus"></i> Nuevo Registro</a>
                            </div>
                            <div class="col-md-4 col-6">
                                <form class="d-flex" role="search">
                                    <input name="buscarpor" class="form-control me-2" type="search" placeholder="Busqueda por apellido" arialabel="Search" value="{{ $buscarpor }}">
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
                                    <th class="border-top-0">Código</th>
                                    <th class="border-top-0">Apeliidos</th>
                                    <th class="border-top-0">Nombres</th>
                                    <th class="border-top-0">Direccion</th>
                                    <th class="border-top-0">Telefono</th>
                                    <th class="border-top-0">Ingreso</th>
                                    <th class="border-top-0">Foto</th>
                                    <th class="border-top-0">Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                            @if (count($docente)<=0)
                                <tr>
                                    <td colspan="8">No hay registros</td>
                                </tr>
                            @else
                                @foreach($docente as $itemdocente) 
                                <tr>
                                    <td>{{$itemdocente->codDocente}}</td>
                                    <td>{{$itemdocente->apellidos}}</td>
                                    <td>{{$itemdocente->nombres}}</td>
                                    <td>{{$itemdocente->direccion}}</td>
                                    <td>{{$itemdocente->telefono}}</td>
                                    <td>{{$itemdocente->fechaIngreso}}</td>
                                    <td>
                                        <a href="{{ $itemdocente->featured_sas_url }}" data-fancybox="gallery" data-caption="Foto del docente">
                                            <img src="{{ $itemdocente->featured_sas_url }}" alt="Foto del docente" class="img-fluid" width="120px">
                                        </a>
                                        
                                    </td>
                                    <td>
                                        <a href="{{ route('docentes.edit', $itemdocente->codDocente) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                    
                                        <a href="{{ route('docentes.confirmar', $itemdocente->codDocente) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{ $docente->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
