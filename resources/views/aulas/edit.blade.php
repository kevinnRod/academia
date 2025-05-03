@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Aulas</h3>
@endsection

@section('rutalink')

@endsection

@section('contenido')
    <div class="row">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Editar sección</h4>
                    
                    <form class="form-horizontal form-material mx-2" method="POST" action="{{ route("aulas.update",['idS' => $seccion->idSeccion, 'idA' => $seccion->idperiodo])}}">
                        @csrf
                        <div class="col form-group">

                        </div>
                        <div class="row row-cols-2">
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Nivel Escolar</label>
                                <div class="col-sm-12 border-bottom">
                                    <select class="form-select shadow-none ps-0 border-0 form-control-line @error('idNivel') is-invalid @enderror" id="idNivel" name="idNivel" onchange="mostrarGrados()">
                                        <option value="">--Nivel Escolar--</option>
                                        @foreach ($nivelEscolar as $itemNivel)
                                        @if ($seccion->grado->idNivel == $itemNivel->idNivel)
                                            <option value="{{$itemNivel->idNivel}}" selected>{{$itemNivel->nivel}}</option>
                                        @else
                                            <option value="{{$itemNivel->idNivel}}">{{$itemNivel->nivel}}</option>
                                        @endif
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
                                        @foreach ($grados as $itemgrados)
                                            @if ($seccion->idGrado == $itemgrados->idGrado)
                                                <option value="{{$itemgrados->idGrado}}" selected>{{$itemgrados->grado}}</option>
                                            @else
                                                @if($seccion->grado->idNivel == $itemgrados->idNivel)
                                                    <option value="{{$itemgrados->idGrado}}" >{{$itemgrados->grado}}</option>
                                                @endif
                                            @endif
                                        @endforeach
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
                                    <input type="text" value="{{$seccion->seccion}}" id="seccion" name="seccion" class="form-control ps-0 form-control-line @error('seccion') is-invalid @enderror" >
                                        @error('seccion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col form-group">
                                <label class="col-md-12 mb-0">Aula</label>
                                <div class="col-md-12">
                                    <input type="text" value="{{$seccion->aula}}" id="aula" name="aula" class="form-control ps-0 form-control-line @error('aula') is-invalid @enderror" >
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
                                <a href="{{ route('cancelarAula', $seccion->idperiodo)}}" class="btn btn-primary"><i class="fas fa-ban"></i> Cancelar</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection