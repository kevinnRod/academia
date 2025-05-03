@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Año Escolar</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('periodo.index') }}">Año Escolar</a></li>
    <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Desea eliminar año escolar?</h4>
                    
                    <div class="col form-group">
                        <label class="col-md-12 mb-0">Nuevo Año</label>
                            <div class="col-md-12">
                                <input type="text" id="idperiodo" name="idperiodo" class="form-control ps-0 form-control-line" value="{{ $periodo->idperiodo }}" disabled>
                            </div>
                    </div>

                    <div class="row row-cols-2">
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Fecha de Inicio</label>
                            <div class="col-md-12">
                                <input type="date" id="fechaInicio" name="fechaInicio" class="form-control ps-0 form-control-line" value="{{ $periodo->fechaInicio }}" disabled>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Fecha de Término</label>
                            <div class="col-md-12">
                                <input type="date" id="fechaTermino" name="fechaTermino" class="form-control ps-0 form-control-line" value="{{ $periodo->fechaTermino }}" disabled>
                            </div>
                        </div>
                    </div>

                    <form class="form-horizontal form-material mx-2" method="POST" action="{{ route("periodo.destroy", $periodo->idperiodo)}}">
                        @method('delete')
                        @csrf
                        <div class="form-group">
                            <div class="col-sm-12 d-flex">
                                <button type="submit" class="btn btn-success mx-auto text-white me-2"><i class="mdi mdi-check-circle"></i> SI</button>
                                <a href="{{ route('cancelarAnyo')}}" class="btn btn-primary"><i class="mdi mdi-close-circle"></i> NO</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection