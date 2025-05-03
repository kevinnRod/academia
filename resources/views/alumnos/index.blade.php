@extends('layouts.plantilla')

@section('titulo')
<h3 class="page-title mb-0 p-0">Alumnos</h3>
@endsection

@section('contenido')
<div class="row">
    <!-- column -->
    <!--form class="form-horizontal form-material mx-2" method="POST" action="">
            csrf -->
            <div class="row">
            <div class="col">
                <div class="card">
                    <h4 class="card-title  p-4">Ver alumnos</h4>

                    <div class="card-body">
                        <form class="form-horizontal form-material mx-2" >
                            <div class="row row-cols-4">
                                <div class="col-3 form-group">
                                    <label class="col-md-12 mb-0">Año Escolar</label>
                                    <div class="col-sm-12 border-bottom">
                                    @php
                                    $periodoSeleccionado = session('periodoSeleccionado');
                                    @endphp

                                    <select class="form-select shadow-none ps-0 border-0 form-control-line" id="idperiodo" name="idperiodo" onchange="mostrarNivel()">
                                        <option value="" selected>--Año Escolar--</option>
                                        @if ($periodoSeleccionado)
                                            <option value="{{ $periodoSeleccionado }}" selected>{{ $periodoSeleccionado }}</option>
                                        @endif
                                    </select>
                                    </div>
                                </div>
                                <div class="col-3 form-group">
                                    <label class="col-md-12 mb-0">Nivel</label>
                                    <div class="col-sm-12 border-bottom">
                                        <select class="form-select shadow-none ps-0 border-0 form-control-line" id="idNivel" name="idNivel" onchange="mostrarGrados()">
                                            <option value="">--Nivel Escolar--</option>
                                            @if($request != null)
                                                @foreach ($nivelEscolar as $itemgNivel)
                                                    @if($request->idNivel == $itemgNivel->idNivel)
                                                        <option value="{{$itemgNivel->idNivel}}" selected>{{$itemgNivel->nivel}}</option>
                                                    @else
                                                        <option value="{{$itemgNivel->idNivel}}">{{$itemgNivel->nivel}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 form-group">
                                    <label class="col-md-12 mb-0">Grado</label>
                                    <div class="col-sm-12 border-bottom">
                                        <select class="form-select shadow-none ps-0 border-0 form-control-line" id="idGrado" name="idGrado" onchange="mostrarSeccion()">
                                            <option value="">--Grado--</option>
                                            @if($request != null)
                                                @foreach ($grado as $itemGrado)
                                                    @if($request->idGrado == $itemGrado->idGrado)
                                                        <option value="{{$itemGrado->idGrado}}" selected>{{$itemGrado->grado}}</option>
                                                    @else
                                                        <option value="{{$itemGrado->idGrado}}">{{$itemGrado->grado}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 form-group">
                                    <label class="col-md-12 mb-0">Seccion</label>
                                    <div class="col-sm-12 border-bottom">
                                        <select class="form-select shadow-none ps-0 border-0 form-control-line" id="idSeccion" name="idSeccion" onchange="mostrarCursoPorNivel()">
                                            <option value="">--Seccion--</option>
                                            @if($request != null)
                                                @foreach ($seccion as $itemSeccion)
                                                    @if($request->idSeccion == $itemSeccion->idSeccion)
                                                        <option value="{{$itemSeccion->idSeccion}}" selected>{{$itemSeccion->seccion}}</option>
                                                    @else
                                                        <option value="{{$itemSeccion->idSeccion}}">{{$itemSeccion->seccion}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>





                                <div class="col-12 form-group">
                                    <div class="col-sm-12 d-flex">
                                        <button type="submit" class="btn btn-success mx-auto me-2 text-white" ><i class="mdi mdi-account-search"></i> Ver alumnos</button>
                                    </div>




                                </div>

                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table user-table">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th class="border-top-0">Nro</th>
                                    <th class="border-top-0">DNI</th>
                                    <th class="border-top-0">Apellidos</th>
                                    <th class="border-top-0">Nombres</th>
                                    <th class="border-top-0">Grado</th>
                                    <th class="border-top-0">Seccion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($alumnos)<=0) <tr>
                                    <td colspan="5">No hay registros</td>
                                    </tr>
                                    @else
                                    @foreach($alumnos as $itemAlumno)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$itemAlumno->alumno->dniAlumno}}</td>
                                        <td>{{$itemAlumno->alumno->apellidos}}</td>
                                        <td>{{$itemAlumno->alumno->nombres}}</td>
                                        <td>{{$itemAlumno->grado->grado}}</td>
                                        <td>{{$itemAlumno->seccion->seccion}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
    <!--/form-->
        <div class="card">
            <div class="col-6 form-group p-2">
                <label class="col-md-12 mb-0">Total de Alumnos:</label>
                    <div class="col-md-3 text-center">
                        <input type="text" id="totalAlumnos" name="totalAlumnos" class="form-control form-control-line text-center" disabled>
                    </div>
            </div>
        </div>
</div>



@endsection