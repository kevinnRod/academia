@extends('layouts.plantilla')

@section('contenido')
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">MANTENIMIENTO DE CÁTEDRA
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

            <div class="row mb-3">
                <div class="col-8">
                    <form action="{{ route('docenteCurso.index') }}" method="GET" class="form-inline">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" placeholder="Apellidos o Nombres" value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-success">Buscar</button>
                    </form>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ route('docenteCurso.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Registro</a>
                </div>
            </div>



            



            <table class="table my-3">

                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Periodo</th>
                        <th scope="col">Nivel</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Docente</th>
                        <th scope="col">Grado</th>
                        <th scope="col">Sección</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($docenteCurso) <= 0)
                        <tr>
                            <td colspan="3">No hay Registro</td>
                        </tr>
                    @else
                        @foreach ($docenteCurso as $itemdocenteCurso)
                            <tr>
                                <td>{{ $itemdocenteCurso->id }}</td>
                                <td>{{ $itemdocenteCurso->idperiodo }}</td>
                                <td>{{ $itemdocenteCurso->curso->nivel->nivel }}</td>
                                <td>{{ $itemdocenteCurso->curso->curso }}</td>
                                <td>{{ $itemdocenteCurso->docente->apellidos}} {{ $itemdocenteCurso->docente->nombres}}</td>
                                <td>{{ $itemdocenteCurso->grado->grado }}</td>
                                <td>{{ $itemdocenteCurso->seccion->seccion }}</td>
                                <td>
                                    <a href="{{ route('docenteCurso.editar', ['id' => $itemdocenteCurso->id, 'codDocente' => $itemdocenteCurso->codDocente, 'idCurso' => $itemdocenteCurso->idCurso, 'idperiodo' => $itemdocenteCurso->idperiodo]) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                    <a href="{{ route('docenteCurso.confirmar', ['id' => $itemdocenteCurso->id, 'codDocente' => $itemdocenteCurso->codDocente, 'idCurso' => $itemdocenteCurso->idCurso, 'idperiodo' => $itemdocenteCurso->idperiodo]) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $docenteCurso->links() }}


        </div>

        <!-- /.card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->
    </div>
@endsection