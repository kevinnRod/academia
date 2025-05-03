@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Grados</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('periodo.index') }}">Año Escolar</a></li>
    <li class="breadcrumb-item" aria-current="page">{{$periodo->idperiodo}}</li>
    <li class="breadcrumb-item active" aria-current="page">Grados</li>
@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Lista de Secciones </h4>
                    
                    <nav class="navbar bg-body-tertiary">
                        <div class="container-fluid text-end">
                            <div class="col">
                                <a href="{{ route('aulas.create', $periodo->idperiodo) }}" class="btn btn-primary"><i class="fas faplus"></i> Registrar nueva seccion</a>
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
                                    <th class="border-top-0">Nivel</th>
                                    <th class="border-top-0">Grado</th>
                                    <th class="border-top-0">Seccion</th>
                                    <th class="border-top-0">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($secciones)<=0)
                                <tr>
                                    <td colspan="4">No hay registros</td>
                                </tr>
                            @else
                                @foreach($secciones as $itemseccion) 
                                <tr>
                                    <td>{{$itemseccion->grado->nivel->nivel}}</td>
                                    <td>{{$itemseccion->grado->grado}}</td>
                                    <td>{{$itemseccion->seccion}}</td>
                                    <td>
                                        <a href="{{ route('aulas.edit', $itemseccion->idSeccion) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                  
                                        <a href="{{ route('aulas.confirmar', $itemseccion->idSeccion) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{ $secciones->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection