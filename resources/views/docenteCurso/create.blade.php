@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Docente_Curso</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('docentes.index') }}">Docente</a></li>
    <li class="breadcrumb-item active" aria-current="page">Cursos</li>
@endsection

@section('contenido')

    <div class="row">
        
        <div class="row">
            
            <div class="col">
                
                <div class="card">
                    <h4 class="float-left p-3" class="card-title">Cátedra</h4>

                    <div class="card-body">
                        <form class="form-horizontal form-material mx-2" method="POST" action="{{ route('docenteCurso.store') }}">
                            @csrf
                            <div class="row row-cols-3">
                                <div class="col-3 form-group">
                                    <label class="col-md-12 mb-0">Código</label>
                                    <div class="col-sm-12 border-bottom">
                                        <select class="form-select shadow-none ps-0 border-0 form-control-line @error('codDocente') is-invalid @enderror" id="codDocente" name="codDocente" onchange="mostrarDocente()">
                                            <option value="">--Código--</option>
                                            @foreach ($docentes as $itemDocente)
                                                <option value="{{$itemDocente->codDocente}}">{{$itemDocente->codDocente}}</option>
                                            @endforeach
                                        </select>
                                        @error('codDocente')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 form-group">
                                    <label class="col-md-12 mb-0">Docente</label>
                                    <div class="col-md-12">
                                        <input type="text" id="docente" name="docente" class="form-control ps-0 form-control-line" disabled>
                                    </div>
                                </div>
                                <div class="col-3 form-group">
                                    <label class="col-md-12 mb-0">Año Escolar</label>
                                    <div class="col-sm-12 border-bottom">
                                            @php
                                                $periodoSeleccionado = session('periodoSeleccionado');
                                                @endphp

                                            <select class="form-select shadow-none ps-0 form-control-line" id="idperiodo" name="idperiodo" >
                                            <option value="" selected>--Año Escolar--</option>
                                                    @if ($periodoSeleccionado)
                                                        <option value="{{ $periodoSeleccionado }}" >{{ $periodoSeleccionado }}</option>
                                                    @endif
                                            </select>


                                        
                                        @error('idperiodo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row row-cols-4">
                                <div class="col-4 form-group">
                                    <label class="col-md-12 mb-0">Curso:</label>
                                    <div class="col-md-12 border-bottom">
                                        <select class="form-select shadow-none ps-0 border-0 form-control-line @error('idCurso') is-invalid @enderror" id="idCurso" name="idCurso">
                                        </select>
                                        @error('idCurso')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-3 form-group">
                                    <label class="col-md-12 mb-0">Nivel:</label>
                                    <div class="col-md-12 border-bottom">
                                        <input type="text" id="nivel" name="nivel" class="form-control ps-0 form-control-line" disabled>
                                    </div>
                                </div>
                                <div class="col-3 form-group">
                                    <label class="col-md-12 mb-0">Grado:</label>
                                    <div class="col-md-12 border-bottom">
                                        <select class="form-select shadow-none ps-0 border-0 form-control-line @error('idGrado') is-invalid @enderror" id="idGrado" name="idGrado" onchange="mostrarSeccion()">
                                        </select>
                                        @error('idGrado')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-2 form-group">
                                    <label class="col-md-12 mb-0">Sección:</label>
                                    <div class="col-md-12 border-bottom">
                                        <select class="form-select shadow-none ps-0 border-0 form-control-line @error('idSeccion') is-invalid @enderror" id="idSeccion" name="idSeccion">
                                        </select>
                                        @error('idSeccion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 d-flex">
                                    <button type="submit" class="btn btn-success mx-auto me-2 text-white"><i class="mdi mdi-check-circle"></i> Grabar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" hidden>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table user-table" >
                                <thead>
                                    <tr>
                                        <th class="border-top-0">Código</th>
                                        <th class="border-top-0">Curso</th>
                                        <th class="border-top-0">Grado</th>
                                        <th class="border-top-0">Sección</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            
                        </div>
                    </div> 
                </div>       
            </div>
        </div>
    </div>

@endsection