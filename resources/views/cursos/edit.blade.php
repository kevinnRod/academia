@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Cursos</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('cursos.index') }}">Cursos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Editar Curso</h4>
                    
                    <form class="form-horizontal form-material mx-2" method="POST" action="{{ route('cursos.update', $curso->idCurso) }}">
                        @method('put')
                        @csrf
                        <div class="row row-cols-2">
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Código</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="xx-xx" value="{{$curso->codCurso}}" id="codCurso" name="codCurso" class="form-control ps-0 form-control-line @error('codCurso') is-invalid @enderror" >
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
                                    <input type="text" placeholder="Nombre del curso" value="{{$curso->curso}}" id="curso" name="curso" class="form-control ps-0 form-control-line @error('curso') is-invalid @enderror" >
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
                                    <select class="form-select shadow-none ps-0 border-0 form-control-line" id="idNivel" name="idNivel">
                                        @foreach ($nivelEscolar as $itemnivel)
                                            @if ($curso->idNivel == $itemnivel->idNivel)
                                                <option value="{{$itemnivel->idNivel}}" selected>{{$itemnivel->nivel}}</option>
                                            @else
                                                <option value="{{$itemnivel->idNivel}}">{{$itemnivel->nivel}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 d-flex">
                                <button type="submit" class="btn btn-success mx-auto me-2 text-white"><i class="fas fa-save"></i> Guardar Seccion</button>
                                <a href="{{ route('cancelarCurso')}}" class="btn btn-primary"><i class="fas fa-ban"></i> Cancelar</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection