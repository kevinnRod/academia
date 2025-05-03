@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Aulas</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('periodo.index') }}">Año Escolar</a></li>
    <li class="breadcrumb-item" aria-current="page">{{$seccion->periodo->idperiodo}}</li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('aulas.index', $seccion->idperiodo) }}">Aulas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Desea eliminar esta sección?</h4>
                    
                    <form class="form-horizontal form-material mx-2" method="POST" action="{{ route("aulas.destroy", $seccion->idSeccion)}}">
                        @csrf
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Año Escolar</label>
                            <div class="col-md-12">
                                <input type="text" value="{{$seccion->periodo->idperiodo}}" id="idperiodo" name="idperiodo" class="form-control ps-0 form-control-line" disabled>
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Grado</label>
                                <div class="col-sm-12 border-bottom">
                                    <input type="text" value="{{$seccion->grado->grado}}" id="grado" name="grado" class="form-control ps-0 form-control-line" disabled>
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Seccion</label>
                                <div class="col-sm-12 border-bottom">
                                    <input type="text" value="{{$seccion->seccion}}" id="seccion" name="seccion" class="form-control ps-0 form-control-line" disabled>
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Aula</label>
                                <div class="col-md-12">
                                    <input type="text" value="{{$seccion->aula}}" id="aula" name="aula" class="form-control ps-0 form-control-line" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 d-flex">
                                <button type="submit" class="btn btn-success mx-auto me-2 text-white"><i class="mdi mdi-check-circle"></i> SI</button>
                                <a href="{{ route('cancelarAula', $seccion->idperiodo)}}" class="btn btn-primary"><i class="mdi mdi-close-circle"></i> NO</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection