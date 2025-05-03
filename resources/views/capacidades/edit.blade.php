@extends('layouts.plantilla')

@section('contenido')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">EDITAR CAPACIDAD</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Cerrar">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <!-- Formulario -->
        <form method="POST" action="{{ route('capacidades.update', $capacidad->idcapacidad) }}">
            @method('put')
            @csrf
            <div class="row">
                <div class="form-group col">
                    <label for="codigo">Código</label>
                    <input type="text" class="form-control" id="idcapacidad" name="idcapacidad" value="{{ $capacidad->idcapacidad }}" disabled>
                </div>
            </div>
            <div class="row">
            <div class="form-group col-md-4">
                        <label for="descripcion">Capacidad</label>
                        <input type="text" class="form-control @error('descripcion') is-invalid @enderror" maxlength="200"
                            id="descripcion" name="descripcion" placeholder="Ingresa la capacidad"  value="{{ $capacidad->descripcion }}">
                        @error('descripcion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="col-3 form-group">
                                <label class="col-md-12 ">Nivel</label>
                                    <div class="col-sm-12 ">
                                        <select class="form-control select2 select2-hidden-accessible selectpicker" id="idNivel" name="idNivel" onchange="mostrarCursoPorNivel1()">
                                                @foreach ($nivel as $itemgNivel)
                                                        <option value="{{$itemgNivel->idNivel}}" @if ($itemgNivel->idNivel == $capacidad->curso->nivel->idNivel) selected @endif>{{$itemgNivel->nivel}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                               


                                <div class="form-group col-md-4">
                        <label for="">Curso</label>

                        <select class="form-control select2 select2-hidden-accessible selectpicker" style="width: 100%;" data-select2-id="1" tabindex="-1"  id="idCurso" name="idCurso" aria-hidden="true"  data-live-search="true">
                                                @foreach ($curso as $itemCurso)
                                                      <option value="{{$itemCurso->idCurso}}" @if ($itemCurso->idCurso == $capacidad->curso->idCurso) selected @endif>{{$itemCurso->curso}}</option>
                                                @endforeach
                        </select>
                    </div>
            <div class="flex">
                <div class="row float-right m-2">
                    <button type="submit" class="btn btn-primary mx-2"><i class="fas fa-save"></i> Guardar</button>
                </div>
                <div class="row float-right m-2">
                    <a href="{{ route('cancelarCapacidad') }}" class="btn btn-danger"><i class="fas fa-ban"></i> Cancelar</a>
                </div>
            </div>



        </form>
    </div>

</div>
@endsection
