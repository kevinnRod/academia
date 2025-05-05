@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Eliminar datos del docente</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('docentes.index') }}">Docentes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Desea eliminar registro?</h4>
                    
                    <div class="col form-group">
                        <label class="col-md-12 mb-0">Código</label>
                        <div class="col-md-12">
                            <input type="text" id="codDocente" name="codDocente" class="form-control ps-0 form-control-line" value="{{ $docente->codDocente }}" disabled>
                        </div>
                    </div>
                    <div class="row row-cols-2">
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Apellidos</label>
                            <div class="col-md-12">
                                <input type="text" id="apellidos" name="apellidos" class="form-control ps-0 form-control-line" value="{{ $docente->apellidos }}" disabled>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Nombre</label>
                            <div class="col-md-12">
                                <input type="text" id="nombres" name="nombres" class="form-control ps-0 form-control-line" value="{{ $docente->nombres }}" disabled>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Direccion</label>
                            <div class="col-md-12">
                                <input type="text" id="direccion" name="direccion" class="form-control ps-0 form-control-line" value="{{ $docente->direccion }}" disabled>
                            </div>
                        </div>

                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Telefono</label>
                            <div class="col-md-12">
                                <input type="text" id="telefono" name="telefono" class="form-control ps-0 form-control-line" value="{{ $docente->telefono }}" disabled>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Fecha de Ingreso</label>
                            <div class="col-md-12">
                                <input type="date" id="fechaIngreso" name="fechaIngreso" class="form-control ps-0 form-control-line" value="{{ $docente->fechaIngreso }}" disabled>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Nivel</label>
                            <div class="col-md-12">
                                <input type="text" id="idNivel" name="idNivel" class="form-control ps-0 form-control-line" value="{{ $docente->nivel->nivel }}" disabled>
                            </div>
                        </div>
                    </div>

                    <form class="form-horizontal form-material mx-2" method="POST" action="{{ route("docentes.destroy",$docente->codDocente)}}">
                        @method('delete')
                        @csrf
                        <div class="form-group">
                            <div class="col-sm-12 d-flex">
                                <button type="submit" class="btn btn-success mx-auto text-white me-2"><i class="mdi mdi-check-circle"></i> SI</button>
                                <a href="{{ route('cancelarDocentes')}}" class="btn btn-primary"><i class="mdi mdi-close-circle"></i> NO</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection