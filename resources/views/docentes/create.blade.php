@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Registrar nuevo docente</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('docentes.index') }}">Docentes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Registrar</li>
@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Datos del docente</h4>
                    
                    <form class="form-horizontal form-material mx-2" method="POST" action="{{ route('docentes.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-cols-2">
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Apellidos</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="Ingrese sus apellidos" id="apellidos" name="apellidos" class="form-control ps-0 form-control-line @error('apellidos') is-invalid @enderror" >
                                    @error('apellidos')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Nombre</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="Ingrese su nombre" id="nombres" name="nombres" class="form-control ps-0 form-control-line @error('nombres') is-invalid @enderror">
                                    @error('nombres')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Direccion</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="Ingrese su direccion" id="direccion" name="direccion" class="form-control ps-0 form-control-line @error('direccion') is-invalid @enderror">
                                    @error('direccion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Estado Civil</label>
                                <div class="col-sm-12 border-bottom">
                                    <select class="form-select shadow-none ps-0 border-0 form-control-line" id="idEstadoCivil" name="idEstadoCivil">
                                        @foreach ($estadosCivil as $itemestadosCivil)
                                            <option value="{{$itemestadosCivil->idEstadoCivil}}">{{$itemestadosCivil->estadoCivil}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Telefono</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="xxx xxx xxx" id="telefono" name="telefono" class="form-control ps-0 form-control-line @error('telefono') is-invalid @enderror">
                                    @error('telefono')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Fecha de Ingreso</label>
                                <div class="col-md-12">
                                    <input type="date" value="2024-08-13" id="fechaIngreso" name="fechaIngreso" class="form-select shadow-none ps-0 border-0 form-control-line">
                                </div>
                            </div>
                            

                            <div class="col form-group">
                                <label for="featured" class="col-md-12 mb-0">Foto del docente</label>
                                <div class="col-sm-12 border-bottom">
                                    <input type="file" name="featured" id="featured" accept="image/jpeg, image/png" class="form-control ps-0 form-control-line @error('featured') is-invalid @enderror" >
                                    @error('featured')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">Seleccione una imagen (tamaño máximo: 2MB)</small>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 d-flex">
                                <button type="submit" class="btn btn-success mx-auto me-2 text-white"><i class="fas fa-save"></i> Guardar Datos</button>
                                <a href="{{ route('cancelarDocentes')}}" class="btn btn-primary"><i class="fas fa-ban"></i> Cancelar</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
