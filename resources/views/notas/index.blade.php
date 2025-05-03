@extends('layouts.plantilla')


@section('titulo')
    <h3 class="page-title mb-0 p-0">Registro de Notas</h3>
@endsection


@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Notas</a></li>
@endsection


@section('contenido')
    <div class="row">
        <div class="row">
            <div class="col">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Registrar Notas</h4>
                        <form class="form-horizontal form-material mx-2"  method="POST" action="{{ route('notas.store') }}">
                        @csrf
                            <div class="row row-cols-4">
                                <div class="col-3 form-group">
                                    <label class="col-md-12 mb-0">Año Escolar</label>
                                    <div class="col-sm-12 border-bottom">
                                            @php
                                                $periodoSeleccionado = session('periodoSeleccionado');
                                                @endphp

                                            <select class="form-select shadow-none ps-0 form-control-line" id="idperiodo" name="idperiodo" onchange="mostrarNivel()">
                                            <option value="" selected>--Año Escolar--</option>
                                                    @if ($periodoSeleccionado)
                                                        <option value="{{ $periodoSeleccionado }}" >{{ $periodoSeleccionado }}</option>
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
                            <div class="row row-cols-2">
                                <div class="col-6 form-group">
                                    <label class="col-md-12 mb-0">Curso:</label>
                                    <div class="col-md-12 border-bottom">
                                        <select class="form-select shadow-none ps-0 border-0 form-control-line" id="idCurso" name="idCurso" onchange="mostrarDocentePorCurso()">
                                            <option value="">--Curso--</option>
                                            @if($request != null)
                                                @foreach ($cursos as $itemCurso)
                                                    @if($request->idCurso == $itemCurso->idCurso)
                                                        <option value="{{$itemCurso->idCurso}}" selected>{{$itemCurso->curso}}</option>
                                                    @else
                                                        <option value="{{$itemCurso->idCurso}}">{{$itemCurso->curso}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 form-group">
                                    <label class="col-md-12 mb-0">Docente:</label>
                                    <div class="col-md-12">
                                        <input type="text" id="docente" name="docente" class="form-control ps-0 form-control-line" disabled>
                                        @if($request != null && $docente !=null)
                                            <option value="{{$docente->docente->apellidos}}, {{$docente->docente->nombres}}"></option>
                                            <input hidden type="text" value="{{$docente->codDocente}}" id="codDocenteN" name="codDocenteN">

                                        @endif
                                        


                                    </div>
                                </div>
                            </div>
                            <div class="row row-cols-6">
                                <div class="col-6 form-group">
                                    <label class="col-md-12 mb-0">Capacidad:</label>
                                    <div class="col-md-12 border-bottom">
                                        <select class="form-select shadow-none ps-0 border-0 form-control-line" id="idcapacidad" name="idcapacidad">
                                            <option value="">--Capacidad--</option>
                                            @if($request != null)
                                                @foreach ($capacidad as $itemCapacidad)
                                                    @if($request->idcapacidad == $itemCapacidad->idcapacidad)
                                                        <option value="{{$itemCapacidad->idcapacidad}}" selected>{{$itemCapacidad->descripcion}}</option>
                                                    @else
                                                        <option value="{{$itemCapacidad->idcapacidad}}">{{$itemCapacidad->descripcion}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="col-6 form-group">
                                    <label class="col-md-12 mb-0">Trimestre:</label>
                                    <div class="col-md-12 border-bottom">
                                        <select class="form-select shadow-none ps-0 border-0 form-control-line" id="idtrimestre" name="idtrimestre" >
                                            <option value="">--Trimestre--</option>
                                            @if($request != null)
                                                @foreach ($trimestre as $itemTrimestre)
                                                    @if($request->idtrimestre == $itemTrimestre->idtrimestre)
                                                    <option value="{{$itemTrimestre->idtrimestre}}" selected>{{$itemTrimestre->descripcion}}</option>
                                                    @else
                                                    <option value="{{$itemTrimestre->idtrimestre}}">{{$itemTrimestre->descripcion}}</option>

                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
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
            <div class="col p-3">
                <button class="btn btn-success" id="colocarNotasBtn" onclick="habilitarCampos()">Habilitar edición</button>
                <button class="btn btn-danger" id="deshabilitarEdicionBtn" onclick="deshabilitarCampos()" style="display: none;">Deshabilitar edición</button>
            </div>
        </div>


        <!--DATOS ADICIONALES-->
        <div style="display: none;">
            @if ($request != null)
                <input type="text" value="{{$request->idperiodo}}" id="idperiodoN" name="idperiodoN">
                <input type="text" value="{{$request->idcapacidad}}" id="idcapacidadN" name="idcapacidadN">
                <input type="text" value="{{$request->idGrado}}" id="idGradoN" name="idGradoN">
                <input type="text" value="{{$request->idSeccion}}" id="idSeccionN" name="idSeccionN">
                <input type="text" value="{{$request->idCurso}}" id="idCursoN" name="idCursoN">
                <input type="text" value="{{$request->idtrimestre}}" id="idtrimestreN" name="idtrimestreN">
            @endif
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- ... tu código anterior ... -->

                            <table class="table user-table">
    <thead>
        <tr>
            <th class="border-top-0">Nro</th>
            <th class="border-top-0">Alumno</th>
            @if($request != null)
                @foreach ($capacidad as $itemCapacidad)
                    <th class="border-top-0">{{ $itemCapacidad->descripcion }}</th>
                @endforeach
            @else
                <th class="border-top-0" >Seleccione el curso para mostrar capacidades</th>
            @endif
            <th class="border-top-0">Promedio</th>
        </tr>
    </thead>
    <tbody>
        @if ($request == null)
            <tr>
                <!-- Aquí puedes mostrar un mensaje si no hay datos seleccionados -->
                <td colspan="{{ count($capacidad) + 2 }}">No hay registros</td>

            </tr>
        @else
            @foreach($alumnos as $itemAlumno)
                <input hidden type="text" value="{{$itemAlumno->dniAlumno}}" id="dniAlumnoN" name="dniAlumnoN">

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $itemAlumno->alumno->apellidos }}, {{ $itemAlumno->alumno->nombres }}
                    </td>
                    @foreach ($capacidad as $itemCapacidad)
                        <td>
                            <select class="form-select trimestre-select capacidad-select" disabled 
                             data-idcapacidad="{{ $itemCapacidad->idcapacidad }}"
                             data-dni="{{ $itemAlumno->dniAlumno }}" 
                             name="notas[{{ $itemAlumno->dniAlumno }}][{{ $itemCapacidad->idcapacidad }}]" >
                                <option value=""></option>
                                <option value="AD">AD</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </td>
                    @endforeach
                    <td>
                        <!-- Campo para mostrar el promedio calculado -->
                        <input class="form-control" name="promedio" min="0" max="20" size="2" readonly>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>


<!-- ... tu código posterior ... -->

                        </div>
                    </div>
                    <div class="col-6 form-group">
                        <label class="col-md-12 mb-0">Total de Alumnos:</label>
                        <div class="col-md-3 text-center">
                            <input type="text" id="totalAlumnos" name="totalAlumnos" class="form-control form-control-line text-center" disabled>
                        </div>
                    </div>


                </div>      
            </div>
        </div>
        <!-- Botón para guardar notas -->
    <div class="row">
        <div class="form-group d-flex justify-content-center">
            <button type="submit" class="btn btn-primary" onclick="guardarNotas()">Guardar Nota</button>
        </div>
    </div>





    </div>


@endsection




@section('script')
<script>

    function habilitarEdicion(btnEditar) {
        // Obtener la fila padre del botón
        var fila = btnEditar.closest('tr');
       
        // Habilitar los campos de edición
        fila.querySelector('#trimestre1').disabled = false;
        fila.querySelector('#trimestre2').disabled = false;
        fila.querySelector('#trimestre3').disabled = false;
       
        // Ocultar el botón de editar
        btnEditar.style.display = 'none';
       
        // Mostrar el botón de guardar
        var btnGuardar = fila.querySelector('.btn-primary');
        btnGuardar.style.display = 'inline-block';
    }


    function deshabilitarEdicion(btnGuardar) {
        // Obtener la fila padre del botón
        var fila = btnGuardar.closest('tr');
       
        // Deshabilitar los campos de edición
        fila.querySelector('#trimestre1').disabled = true;
        fila.querySelector('#trimestre2').disabled = true;
        fila.querySelector('#trimestre3').disabled = true;
       
        // Obtener los valores de los campos
        var dniAlumno = fila.querySelector('#dniAlumno').value;
        var trimestre1 = fila.querySelector('#trimestre1').value;
        var trimestre2 = fila.querySelector('#trimestre2').value;
        var trimestre3 = fila.querySelector('#trimestre3').value;
       
        // Obtener los datos adicionales
        var idperiodo = document.getElementById('idperiodoN').value;
        var idcapacidad = document.getElementById('idcapacidadN').value;
        var idGrado = document.getElementById('idGradoN').value;
        var idSeccion = document.getElementById('idSeccionN').value;
        var idCurso = document.getElementById('idCursoN').value;
       
        // Enviar la solicitud AJAX para guardar los datos
        var url = '/guardarNota/' + dniAlumno + '/' + trimestre1 + '/' + trimestre2 + '/' + trimestre3 +  '/' + idperiodo + '/' + idcapacidad + '/' + idGrado + '/' + idSeccion + '/' + idCurso;




        fetch(url) /*, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })*/
        .then(response => response.json())
        .then(result => {
            // Aquí puedes manejar la respuesta del servidor, como mostrar un mensaje de éxito
            console.log(result);
        })
        .catch(error => {
            console.error('Error al guardar los datos:', error);
        });
       
        // Ocultar el botón de guardar
        btnGuardar.style.display = 'none';
       
        // Mostrar el botón de editar
        var btnEditar = fila.querySelector('.btn-warning');
        btnEditar.style.display = 'inline-block';
    }

    var csrfToken = "{{ csrf_token() }}";
    
function guardarNotas() {
    let cont = 0;
    var idperiodo = document.getElementById('idperiodoN').value;
    var idGrado = document.getElementById('idGradoN').value;
    var idSeccion = document.getElementById('idSeccionN').value;
    var idCurso = document.getElementById('idCursoN').value;
    var idtrimestre = document.getElementById('idtrimestreN').value;
    var codDocente = document.getElementById('codDocenteN').value;

    var alumnos = [];

    // Obtiene todos los elementos de capacidad-select
    var elementosCapacidad = document.querySelectorAll('.capacidad-select');

    elementosCapacidad.forEach(function (elemento) {
        var dniAlumno = elemento.getAttribute('data-dni');
        var idCapacidad = elemento.getAttribute('data-idcapacidad');
        var nota = elemento.value;

        // Busca el alumno en la lista de alumnos o crea uno nuevo si no existe
        var alumno = alumnos.find((alumno) => alumno.dni === dniAlumno);
        if (!alumno) {
            alumno = {
                dni: dniAlumno,
                capacidades: [],
            };
            alumnos.push(alumno);
        }

        // Agrega la capacidad y nota al alumno
        alumno.capacidades.push({ idCapacidad: idCapacidad, nota: nota });
    });

    console.log('Lista de alumnos:', alumnos);

    var data = {
        idperiodo: idperiodo,
        idGrado: idGrado,
        idSeccion: idSeccion,
        idCurso: idCurso,
        idtrimestre: idtrimestre,
        codDocente: codDocente,
        alumnos: alumnos,
    };


    fetch('/guardarNotas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken // Aquí se incluye el token CSRF en el encabezado
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(result => {
            alert('Notas guardadas con éxito');
            if (result.redirect) {
                window.location.href = result.redirect; // Redirige a la URL deseada
            }
        })

        .catch(error => {
            console.error('Error al guardar las notas:', error);
        });
    
}


    


</script>
   
   
@endsection





