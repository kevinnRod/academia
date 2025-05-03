@extends('layouts.plantilla')

@section('contenido')
    <form class="form-horizontal form-material mx-2" method="POST" action="{{ route('matriculas.store') }}" enctype="multipart/form-data">
        @csrf
<!-- DATOS MATRÍCULA Y DOCENTES -->
<div class="row mt-3">
    <!-- Columna para Datos de Matrícula -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h4 class="card-title mb-0">Datos de la Matrícula</h4>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Periodo -->
                    <div class="col-md-6">
                        <label for="idperiodo" class="form-label">Periodo</label>
                        <select class="form-select" id="idperiodo" name="idperiodo" onchange="cargarTiposCiclo()">
                            <option value="" selected>-- Seleccionar Periodo --</option>
                            @foreach ($periodos as $periodo)
                                <option value="{{ $periodo->idperiodo }}" {{ $idperiodoSeleccionado == $periodo->idperiodo ? 'selected' : '' }}>
                                    {{ $periodo->idperiodo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Tipo de Ciclo -->
                    <div class="col-md-6">
                        <label for="idtipociclo" class="form-label">Tipo de Ciclo</label>
                        <select class="form-select" id="idtipociclo" name="idtipociclo" onchange="cargarAreas()">
                            <option value="" selected>-- Seleccionar Tipo de Ciclo --</option>
                            @foreach ($tiposCiclo as $tipo)
                                <option value="{{ $tipo->idtipociclo }}">{{ $tipo->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Área -->
                    <div class="col-md-6">
                        <label for="idarea" class="form-label">Área</label>
                        <select class="form-select" id="idarea" name="idarea" onchange="cargarCiclos(); cargarCarreras();">
                            <option value="" selected>-- Seleccionar Área --</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->idarea }}">{{ $area->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Ciclo -->
                    <div class="col-md-6">
                        <label for="idciclo" class="form-label">Ciclo</label>
                        <select class="form-select" id="idciclo" name="idciclo" onchange="cargarAulas()">
                            <option value="" selected>-- Seleccionar Ciclo --</option>
                        </select>
                    </div>
                    <!-- Aula -->
                    <div class="col-md-6">
                        <label for="idaula" class="form-label">Aula</label>
                        <select class="form-select" id="idaula" name="idaula" onchange="cargarAlumnos(); cargarDocentes(); mostrarHorario();">
                            <option value="" selected>-- Seleccionar Aula --</option>
                            <!-- Opciones se llenarán con JavaScript -->
                        </select>
                    </div>

                    <div class="col-md-6 ">
                        <div>
                            <label for="horario" class="form-label">Horario del Aula</label>
                            <div id="horario-container">
                                <!-- La imagen del horario se mostrará aquí -->
                                
                            </div>
                        </div><br>
                        <div>
                            <button  class="btn btn-primary">Ampliar horario</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Columna para Tabla de Docentes -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="card-title mb-0" id="docentes-count">Docentes en el Aula Seleccionada: </h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código Docente</th>
                            <th>Docente</th>
                            <th>Curso</th>
                        </tr>
                    </thead>
                    <tbody id="docentes-table-body">
                        <!-- Las filas generadas por JavaScript se insertarán aquí -->
                    </tbody>
                </table>
                <div class="pagination-container">
                    <!-- La paginación se insertará aquí -->
                </div>
                
            </div>
        </div>
    </div>

</div>


        <!-- DATOS ALUMNO Y DATOS PAGO -->
        <div class="row">
            <!-- DATOS ALUMNO -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="card-title mb-0">Datos del Alumno</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- DNI del Alumno -->
                            <div class="col-md-6">
                                <label for="dniAlumno" class="form-label">DNI del Alumno</label>
                                <input type="text" name="dniAlumno" id="dniAlumno" class="form-control" placeholder="DNI del Alumno" required>
                            </div>
                            <!-- Apellidos -->
                            <div class="col-md-6">
                                <label for="apellidosAlumno" class="form-label">Apellidos</label>
                                <input type="text" name="apellidosAlumno" id="apellidosAlumno" class="form-control" placeholder="Apellidos" required>
                            </div>
                            <!-- Nombres -->
                            <div class="col-md-6">
                                <label for="nombresAlumno" class="form-label">Nombres</label>
                                <input type="text" name="nombresAlumno" id="nombresAlumno" class="form-control" placeholder="Nombres" required>
                            </div>
                            <!-- Fecha de Nacimiento -->
                            <div class="col-md-6">
                                <label for="fechanacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" name="fechaNacimiento" id="fechanacimiento" class="form-control" required>
                            </div>
                            <!-- Carrera -->
                            <div class="col-md-6">
                                <label for="idcarrera" class="form-label">Carrera</label>
                                <select class="form-select" name="idcarrera" id="idcarrera" required>
                                    <option value="" selected>-- Seleccionar Carrera --</option>
                                    <!-- @foreach ($carreras as $carrera)
                                    <option value="{{ $carrera->idcarrera }}">{{ $carrera->descripcion }}</option>
                                    @endforeach -->
                                </select>
                            </div>
                            <!-- Foto del Alumno -->
                            <div class="col-md-6">
                                <label for="featured" class="form-label">Foto del Alumno</label>
                                <input type="file" name="featured" id="featured" accept="image/jpeg, image/png" class="form-control @error('featured') is-invalid @enderror">
                                @error('featured')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">Seleccione una imagen (tamaño máximo: 2MB)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DATOS PAGO -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="card-title mb-0">Datos del Pago</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Medio de Pago -->
                            <div class="col-md-12">
                                <label for="idmediopago" class="form-label">Medio de Pago</label>
                                <select name="idmediopago" id="idmediopago" class="form-select" required>
                                    <option value="" disabled selected>Seleccione un medio de pago</option>
                                    @foreach($mediopago as $medio)
                                        <option value="{{ $medio->idmediopago }}">{{ $medio->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Número de Pago -->
                            <div class="col-md-6">
                                <label for="nropago" class="form-label">Número de Pago</label>
                                <input type="text" name="nropago" id="nropago" class="form-control" placeholder="Número de Pago" required>
                            </div>
                            <!-- Fecha de Pago -->
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha de Pago</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" required>
                            </div>
                            <!-- Monto -->
                            <div class="col-md-6">
                                <label for="monto" class="form-label">Monto</label>
                                <input type="number" name="monto" id="monto" class="form-control" placeholder="Monto" required>
                            </div>
                            <!-- Imagen del Comprobante -->
                            <div class="col-md-6">
                                <label for="rutaImagen" class="form-label">Comprobante de Pago</label>
                                <input type="file" name="rutaImagen" id="rutaImagen" accept="image/jpeg, image/png" class="form-control @error('rutaImagen') is-invalid @enderror">
                                @error('rutaImagen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">Seleccione una imagen del comprobante (tamaño máximo: 2MB)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOTONES -->
        <div class="row mt-3">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <!-- Conteo y Tabla de Alumnos -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="card-title mb-0">Alumnos Registrados</h4>
                </div>
                <div class="card-body">
                    <h4 id="alumnos-count" class=""></h4>
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>N° Matrícula</th>
                                <th>DNI</th>
                                <th>Apellidos</th>
                                <th>Nombres</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Foto</th>
                                <th>Periodo</th>
                                <th>Tipo de Ciclo</th>
                                <th>Área</th>
                                <th>Ciclo</th>
                                <th>Aula</th>

                            </tr>
                        </thead>
                        <tbody id="alumnos-table-body">
                            <!-- Las filas generadas por JavaScript se insertarán aquí -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
