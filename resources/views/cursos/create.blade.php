@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Cursos</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('cursos.index') }}">Cursos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Registrar</li>
@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Crear Curso</h4>
                    
                    <form class="form-horizontal mx-2" method="POST" action="{{ route('cursos.store') }}">
                        @csrf
                        <div class="row row-cols-2">
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Código</label>
                                <div class="col-md-12">
                                    <input type="text"  id="codCurso" name="codCurso" class="form-control @error('codCurso') is-invalid @enderror" >
                                        @error('codCurso')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Curso</label>
                                <div class="col-md-12">
                                    <input type="text" id="curso" name="curso" class="form-control   @error('curso') is-invalid @enderror" >
                                        @error('curso')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Nivel</label>
                                <div class="col-sm-12 border-bottom">
                                    <select class="form-select  ps-0 border-0 " id="idNivel" name="idNivel">
                                        @foreach ($nivelEscolar as $itemnivel)
                                            <option value="{{$itemnivel->idNivel}}">{{$itemnivel->nivel}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 d-flex">
                                <button type="submit" class="btn btn-success mx-auto me-2 text-white"><i class="fas fa-save"></i> Guardar Curso</button>
                                <a href="{{ route('cancelarCurso')}}" class="btn btn-primary"><i class="fas fa-ban"></i> Cancelar</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection