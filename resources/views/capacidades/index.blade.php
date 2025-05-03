@extends('layouts.plantilla')

@section('contenido')
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">MANTENIMIENTO DE CAPACIDADES/ASIGNATURAS
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        

        <div class="card-body">

            <!-- Ventana flotante (with) para mostrar alerta -->
            @if (session('datos'))
                <div id="mensaje">
                    @if (session('datos'))
                        <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                            {{ session('datos') }}
                            <button type="butto" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            @endif

            <nav class="navbar bg-body-tertiary">
                        <div class="container-fluid justify-content-end">
                            <div class="col">
                                <a href="{{ route('capacidades.create') }}" class="btn btn-primary me-4"><i class="fas fa-plus"></i> Nueva capacidad</a>
                            </div>
                            <div class="col-md-4 col-6">
                                <form class="d-flex" role="search">
                                    <input name="buscarpor" class="form-control me-2" type="search" placeholder="Busqueda por capacidad" arialabel="Search" value="{{ $buscarpor }}">
                                    <button class="btn btn-success" type="submit">Buscar</button>
                                </form>
                            </div>
                        </div>
                    </nav>
            <!-- /.alertas -->




            <table class="table my-3">

                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Capacidad</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Nivel</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($capacidades) <= 0)
                        <tr>
                            <td colspan="3">No hay Registro</td>
                        </tr>
                    @else
                        @foreach ($capacidades as $itemcapacidad)
                            <tr>
                                <td>{{ $itemcapacidad->idcapacidad }}</td>
                                <td>{{ $itemcapacidad->descripcion }}</td>
                                <td>{{ $itemcapacidad->curso->curso }}</td>
                                <td>{{ $itemcapacidad->curso->nivel->nivel }}</td>

                                <td>
                                <a href="{{ route('capacidades.edit', $itemcapacidad->idcapacidad)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Editar</a>

                                <a href="{{ route('capacidades.confirmar', $itemcapacidad->idcapacidad) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</a>

                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $capacidades->links() }}


        </div>

        <!-- /.card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->
    </div>
@endsection