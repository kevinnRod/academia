@extends('layouts.plantilla')

@section('contenido')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">EDITAR CÁTEDRA</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Cerrar">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="form-group col-2">
                <label for="codigo">Periodo</label>
                    <input type="text" class="form-control"  value="{{ $docente_curso->idperiodo }}" disabled>
            </div>
            <div class="form-group col-2">
                <label for="codigo">Código</label>
                    <input type="text" class="form-control"  value="{{ $docente_curso->id }}" disabled>
            </div>
            <div class="form-group col-2">
                <label for="codigo">Docente</label>
                    <input type="text" class="form-control" value=" {{ $docente_curso->docente->apellidos }}, {{ $docente_curso->docente->nombres }} " disabled>
            </div>
            <div class="form-group col-2">
                <label for="codigo">Curso</label>
                    <input type="text" class="form-control" value="{{ $docente_curso->curso->curso }}" disabled>
            </div>
            <div class="form-group col-2">
                <label for="codigo">Grado</label>
                    <input type="text" class="form-control"  value="{{ $docente_curso->grado->grado }}" disabled>
            </div>
            <div class="form-group col-2">
                <label for="codigo">Seccion</label>
                    <input type="text" class="form-control"  value="{{ $docente_curso->seccion->seccion }}" disabled>
            </div>
        </div>
    </div>

    <div class="card-body">
        <!-- Formulario -->
        <form class="form-horizontal form-material mx-2" method="POST" action="{{ route('docenteCurso.update', ['id' => $docente_curso->id, 'codDocente' => $docente_curso->codDocente, 'idCurso' => $docente_curso->idCurso, 'idperiodo' => $docente_curso->idperiodo]) }}">
        @method('PUT')
        @csrf
            
            <div class="row row-cols-3">

                                <div class="form-group col-2">
                                <label class="col-md-12 mb-0">Código de cátedra</label>
                                        <input type="text" class="form-control p-3"   value="{{ $docente_curso->id }}" disabled>
                                </div>
                                <div class="col-3 form-group">
                                    <label class="col-md-12 mb-0">Código del docente</label>
                                    <div class="col-sm-12 border-bottom">
                                        <select disabled class="form-select shadow-none ps-0 border-0 form-control-line @error('codDocente') is-invalid @enderror" id="codDocente" name="codDocente" onchange="mostrarDocente()">
                                            <option value="">--Código--</option>
                                            @foreach ($docentes as $itemDocente)
                                            <option value="{{ $itemDocente->codDocente }}" @if ($itemDocente->codDocente == $docente_curso->codDocente) selected @endif>
                                                {{ $itemDocente->codDocente }}
                                            </option>                                            
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
                                        <select class="form-select shadow-none ps-0 border-0 form-control-line @error('idperiodo') is-invalid @enderror" id="idperiodo" name="idperiodo">
                                            <option value="">--Año--</option>
                                            @foreach ($periodo as $itemAnyo)
                                            <option value="{{ $itemAnyo->idperiodo }}" @if ($itemAnyo->idperiodo == $docente_curso->idperiodo) selected @endif>
                                                {{ $itemAnyo->idperiodo }}
                                            </option>                                            
                                            @endforeach
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
                                            <option value="{{ $docente_curso->curso->curso }}" selected>{{ $docente_curso->curso->curso }}</option>

                                    
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


            <div class="flex">
                <div class="row float-right m-2">
                    <button type="submit" class="btn btn-primary mx-2"><i class="fas fa-save"></i> Guardar</button>
                </div>
                <div class="row float-right m-2">
                    <a href="javascript:history.back()" class="btn btn-danger">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>



        </form>
    </div>

</div>
@endsection

@section('script')
<script>
    // Ejecutar mostrarDocente() automáticamente al cargar la página
    $(document).ready(function() {
        mostrarDocente();

        
    });

    
</script>
@endsection
