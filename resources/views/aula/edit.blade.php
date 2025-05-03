@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Editar Aula</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Editar Aula</li>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('aula.update', $aula->idaula) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="col form-group">
                            <div class="col-md-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $aula->descripcion }}">
                                @error('descripcion')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Periodo</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none ps-0 form-control-line" id="idperiodo" name="idperiodo" onchange="cargarTiposCiclo()">
                                    <option value="" selected>--Periodo--</option>
                                    @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->idperiodo }}" {{ $periodo->idperiodo == $periodo->idperiodo ? 'selected' : '' }}>
                                        {{ $periodo->idperiodo }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Tipo de Ciclo</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none ps-0 form-control-line" id="idtipociclo" name="idtipociclo" onchange="cargarCiclos()">
                                    <option value="" selected>--Tipo de Ciclo--</option>
                                    @foreach ($tiposCiclo as $tipo)
                                    <option value="{{ $tipo->idtipociclo }}" {{ $tipo->idtipociclo == $aula->ciclo->idtipociclo ? 'selected' : '' }}>
                                        {{ $tipo->descripcion }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Área</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none ps-0 form-control-line" id="idarea" name="idarea" onchange="cargarCiclos(); cargarCarreras();">
                                    <option value="" selected>--Área--</option>
                                    @foreach ($areas as $area)
                                    <option value="{{ $area->idarea }}" {{ $area->idarea == $aula->ciclo->idarea ? 'selected' : '' }}>
                                        {{ $area->descripcion }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Ciclo</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none ps-0 form-control-line" id="idciclo" name="idciclo" >
                                    <option value="" selected>--Ciclo--</option>
                                    @foreach ($ciclos as $ciclo)
                                    <option value="{{ $ciclo->idciclo }}" {{ $ciclo->idciclo == $aula->ciclo->idciclo ? 'selected' : '' }}>
                                        {{ $ciclo->descripcion }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col form-group">
                            <label for="rutaHorario" class="form-label">Horario (Imagen)</label>
                            <input type="file" class="form-control" id="rutaHorario" name="rutaHorario">
                            @if ($aula->rutaHorario)
                            
                                    <a href="{{ asset($aula->rutaHorario) }}" class="fancybox" data-fancybox="gallery">
                                        <img src="{{ asset($aula->rutaHorario) }}" alt="Foto del alumno" class="img-fluid mt-2" width="200px">
                                    </a>
                             
                            @endif
                            @error('rutaHorario')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('aula.index') }}" class="btn btn-secondary">Cancelar</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
