@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Año Escolar</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('periodo.index') }}">Año Escolar</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Datos del año</h4>
                    
                    <form class="form-horizontal form-material mx-2" method="POST" action="{{ route("periodo.update",$periodo->idperiodo)}}">
                        @method('put')
                        @csrf
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Periodo</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="20XX" id="idperiodo" name="idperiodo" class="form-control ps-0 form-control-line @error('anyo') is-invalid @enderror" value="{{ $periodo->idperiodo }}">
                                @error('anyo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Fecha de Inicio</label>
                                <div class="col-md-12">
                                    <input type="date" value="{{ $periodo->fechaInicio }}" id="fechaInicio" name="fechaInicio" class="form-select shadow-none ps-0 border-0 form-control-line">
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Fecha de Término</label>
                                <div class="col-md-12">
                                    <input type="date" value="{{ $periodo->fechaTermino }}" id="fechaTermino" name="fechaTermino" class="form-select shadow-none ps-0 border-0 form-control-line">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 d-flex">
                                <button type="submit" class="btn btn-success mx-auto me-2 text-white"><i class="fas fa-save"></i> Guardar Datos</button>
                                <a href="{{ route('cancelarAnyo')}}" class="btn btn-primary"><i class="fas fa-ban"></i> Cancelar</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection