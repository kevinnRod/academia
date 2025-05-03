@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Aulas</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('periodo.index') }}">Año Escolar</a></li>
    <li class="breadcrumb-item" aria-current="page">{{$periodo->idperiodo}}</li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('aulas.index', $periodo->idperiodo) }}">Aulas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Registrar</li>
@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Crear nueva sección</h4>
                    
                    <form class="form-horizontal form-material mx-2" method="POST" action="{{ route('aulas.store', $periodo->idperiodo) }}">
                        @csrf
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Año Escolar</label>
                            <div class="col-md-12">
                                <input type="text" value="{{$periodo->idperiodo}}" id="idperiodo" name="idperiodo" class="form-control ps-0 form-control-line" disabled>
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Nivel Escolar</label>
                                <div class="col-sm-12 border-bottom">
                                    <select class="form-select shadow-none ps-0 border-0 form-control-line @error('idNivel') is-invalid @enderror" id="idNivel" name="idNivel" onchange="mostrarGrados()">
                                        <option value="">--Nivel Escolar--</option>
                                        @foreach ($nivelEscolar as $itemNivel)
                                            <option value="{{$itemNivel->idNivel}}">{{$itemNivel->nivel}}</option>
                                        @endforeach
                                    </select>
                                    @error('idNivel')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Grado</label>
                                <div class="col-sm-12 border-bottom">
                                    <select class="form-select shadow-none ps-0 border-0 form-control-line @error('idGrado') is-invalid @enderror" id="idGrado" name="idGrado">
                                        <option value="">--Grado--</option>
                                    </select>
                                    @error('idGrado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Seccion</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="A" id="seccion" name="seccion" class="form-control ps-0 form-control-line @error('seccion') is-invalid @enderror" >
                                        @error('seccion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col form-group" hidden>
                                <label class="col-md-12 mb-0">Aula</label>
                                <div class="col-md-12">
                                    <input type="text" value ='101' id="aula" name="aula" class="form-control ps-0 form-control-line @error('aula') is-invalid @enderror" >
                                        @error('aula')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 d-flex">
                                <button type="submit" class="btn btn-success mx-auto me-2 text-white"><i class="fas fa-save"></i> Guardar Seccion</button>
                                <a href="{{ route('cancelarAula', $periodo->idperiodo)}}" class="btn btn-primary"><i class="fas fa-ban"></i> Cancelar</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection