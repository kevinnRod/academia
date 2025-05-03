@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Cursos</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('cursos.index') }}">Cursos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Eliminar</li>
@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Desea eliminar este curso?</h4>
                    
                    <div class="row row-cols-2">
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Código</label>
                            <div class="col-md-12">
                                <input type="text" value="{{$curso->codCurso}}" id="codCurso" name="codCurso" class="form-control ps-0 form-control-line" disabled>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Curso</label>
                            <div class="col-sm-12 border-bottom">
                                <input type="text" value="{{$curso->curso}}" id="curso" name="curso" class="form-control ps-0 form-control-line" disabled>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Nivel</label>
                            <div class="col-md-12">
                                <input type="text" value="{{$curso->nivel->nivel}}" id="nivel" name="nivel" class="form-control ps-0 form-control-line" disabled>
                            </div>
                        </div>
                    </div>
                        
                    <form class="form-horizontal form-material mx-2" method="POST" action="{{ route("cursos.destroy", $curso->idCurso)}}">
                        @method('delete')
                        @csrf
                        <div class="form-group">
                            <div class="col-sm-12 d-flex">
                                <button type="submit" class="btn btn-success mx-auto me-2 text-white"><i class="mdi mdi-check-circle"></i> SI</button>
                                <a href="{{ route('cancelarCurso')}}" class="btn btn-primary"><i class="mdi mdi-close-circle"></i> NO</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection