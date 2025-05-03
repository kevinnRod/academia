@extends('layouts.plantilla')


@section('titulo')
    <h3 class="page-title mb-0 p-0">Reporte de Notas</h3>
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
                        <h4 class="card-title">Reporte de Notas</h4>
                        <form class="form-horizontal form-material mx-2" method="POST" id="frm-reporte" action="{{ route('notas.reporte.enviar') }}">
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
                                                    <option value="{{ $periodoSeleccionado }}">{{ $periodoSeleccionado }}</option>
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
                                        <select class="form-select shadow-none ps-0 border-0 form-control-line" id="idSeccion" name="idSeccion" onchange="mostrarCursoPorNivel1()">
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
                                    <label hidden class="col-md-12 mb-0">Docente:</label>
                                    <div hidden class="col-md-12">
                                        @if($request != null && $docente !=null)
                                            <option value="{{$docente->apellidos}}, {{$docente->nombres}}"></option>
                                            <input hidden type="text" value="{{$docente->codDocente}}" id="codDocenteN" name="codDocenteN">

                                        @endif
                                        


                                    </div>

                                    <label class="col-md-12 mb-0">Docente:</label>
                                    <div class="col-md-12">
                                        @if($request == null)
                                        <input type="text" id="docente" name="docente" class="form-control ps-0 form-control-line" disabled>
                                        @endif
                                        @if($request != null && $docente !=null)
                                            <input type="text" id="docente" name="docente" value="{{ $docente->apellidos }}, {{ $docente->nombres }}" class="form-control ps-0 form-control-line" disabled>
                                            <input hidden type="text" value="{{ $docente->codDocente }}" id="codDocenteN1" name="codDocenteN1">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 form-group" hidden>
                                    <label class="col-md-12 mb-0">Docente:</label>
                                    <div class="col-md-12">
                                        <input type="text" id="docente1" name="docente1" class="form-control ps-0 form-control-line" disabled>
                                        @if($request != null && $docente !=null)
                                            <option value="{{$docente->codDocente}}"></option>
                                            <input hidden type="text" value="{{$docente->codDocente}}" id="codDocenteNN" name="codDocenteNN">

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
                            <button class="btn btn-primary" id="colocarNotasBtn" onclick="habilitarCampos()">Colocar notas</button>
                            <button class="btn btn-danger" id="deshabilitarEdicionBtn" onclick="deshabilitarCampos()" style="display: none;">Deshabilitar edición</button>
                        </div>
                    </div>

        @if (isset($error))
            <div class="alert alert-danger text-center">{{ $error }}</div>
        @endif


        <!--DATOS ADICIONALES-->
        <div style="display: none;">
            @if ($request != null)
                <input type="text" value="{{$request->idperiodo}}" id="idperiodoN" name="idperiodoN">
                <input type="text" value="{{$request->idGrado}}" id="idGradoN" name="idGradoN">
                <input type="text" value="{{$request->idSeccion}}" id="idSeccionN" name="idSeccionN">
                <input type="text" value="{{$request->idCurso}}" id="idCursoN" name="idCursoN">
                <input type="text" value="{{$request->idtrimestre}}" id="idtrimestreN" name="idtrimestreN">
                <input type="text" value="{{$request->codDocente}}" id="codDocenteN" name="codDocenteN">
            @endif
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table user-table">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">Nro</th>
                                        <th class="border-top-0">Alumno</th>
                                        @if ($request != null)
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
                                </div>

                                        @foreach ($alumnosPorCapacidad as $alumnoId => $notasPorCapacidad)
                                        
                                        
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @php
                                                        $alumno = $alumnosNotas->where('dniAlumno', $alumnoId)->first();
                                                    @endphp
                                                    {{ $alumno->alumno->apellidos }}, {{ $alumno->alumno->nombres }}
                                                </td>

                                                    @foreach ($capacidad as $itemCapacidad)
                                                        
                                                        <td>
                                                            <select class="form-select trimestre-select capacidad-select" disabled
                                                                    data-idcapacidad="{{ $itemCapacidad->idcapacidad }}"
                                                                    data-dni="{{ $alumnoId }}"
                                                                    name="notas[{{ $alumnoId }}][{{ $itemCapacidad->idcapacidad }}]">
                                                                <option value=""></option>
                                                                <option value="AD" @if(isset($notasPorCapacidad[$itemCapacidad->idcapacidad]) && $notasPorCapacidad[$itemCapacidad->idcapacidad] === 'AD') selected @endif>AD</option>
                                                                <option value="A" @if(isset($notasPorCapacidad[$itemCapacidad->idcapacidad]) && $notasPorCapacidad[$itemCapacidad->idcapacidad] === 'A') selected @endif>A</option>
                                                                <option value="B" @if(isset($notasPorCapacidad[$itemCapacidad->idcapacidad]) && $notasPorCapacidad[$itemCapacidad->idcapacidad] === 'B') selected @endif>B</option>
                                                                <option value="C" @if(isset($notasPorCapacidad[$itemCapacidad->idcapacidad]) && $notasPorCapacidad[$itemCapacidad->idcapacidad] === 'C') selected @endif>C</option>
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
                        </div>
                    </div>
                    <div class="col-6 form-group">
                        <label class="col-md-12 mb-0">Total de Alumnos:</label>
                        <div class="col-md-3 text-center">
                            <input type="text" id="totalAlumnos" name="totalAlumnos" class="form-control form-control-line text-center" disabled>
                        </div>
                    </div>

                    @if($request != null)
                        <div class="row p-3">
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success mx-auto me-2 text-white"  onclick ="mostrarConsola()"> <i class="mdi mdi-content-save-all"></i>Actualizar notas</button>
                            </div>
                        </div>


                        <div class="flex m-auto p-2">
                            <a target="_blank" href="{{ route('notas.informepdf', [
                                'idperiodo' => $request ? $request->idperiodo : 'valor_predeterminado',
                                'idCurso' => $request ? $request->idCurso : 'valor_predeterminado',
                                'idGrado' => $request ? $request->idGrado : 'valor_predeterminado',
                                'idSeccion' => $request ? $request->idSeccion : 'valor_predeterminado',
                                'idtrimestre' => $request ? $request->idtrimestre : 'valor_predeterminado',
                            ]) }}" class="btn btn-success btn-sm "><i class="fas fa-print"></i>Generar Informe Anual PDF</a>

                            <a target="_blank" href="{{ route('notas.informetrimestre', [
                                'idperiodo' => $request ? $request->idperiodo : 'valor_predeterminado',
                                'idCurso' => $request ? $request->idCurso : 'valor_predeterminado',
                                'idGrado' => $request ? $request->idGrado : 'valor_predeterminado',
                                'idSeccion' => $request ? $request->idSeccion : 'valor_predeterminado',
                                'idtrimestre' => $request ? $request->idtrimestre : 'valor_predeterminado',
                            ]) }}" class="btn btn-warning btn-sm "><i class="fas fa-print"></i>Generar Informe Trimestre PDF</a>

                        </div>
                    @else
                        <div class="row p-3">
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success mx-auto me-2 text-white" disabled> <i class="mdi mdi-content-save-all"></i>Actualizar notas</button>
                            </div>
                        </div>

                        <div class="flex m-auto p-">
                            <button target="_blank" class="btn btn-success btn-sm m-2" disabled><i class="fas fa-print"></i>Generar Informe Anual PDF</a>

                            <button target="_blank" class="btn btn-warning btn-sm m-2" disabled><i class="fas fa-print"></i>Generar Informe Trimestre PDF</a>

                        </div>
                    @endif
                    
                    
                </div>      
            </div>
        </div>
    </div>
    


@endsection


@section('script')
<script>
    var csrfToken = "{{ csrf_token() }}";

function calcularPromedio(fila) {
      const selectores = fila.querySelectorAll('select[name^="notas["]');

      let sumaNotas = 0;
      let cantidadNotas = 0;
      

      selectores.forEach(selector => {

          if (selector.value) {
              
              sumaNotas += convertirNota(selector.value);
              cantidadNotas++;

          }
      });
      //que sea igual al total de capacidades* 
      if (cantidadNotas > 0) {
          const promedio = sumaNotas / cantidadNotas;
          console.log('PROMEDIO NUMERO:', Math.round(promedio));
          
          promedioN = Math.round(promedio);

          fila.querySelector('input[name="promedio"]').value = convertirPromedio(promedioN);

      } else {
          fila.querySelector('input[name="promedio"]').value = '';
      }
  }

  function convertirNota(nota) {
      const valoresNotas = { 'AD': 4, 'A': 3, 'B': 2, 'C': 1 };
      return valoresNotas[nota];
  }

  function convertirPromedio(promedio){
      if (promedio == 4) {
          promedioLetra = "AD";
      } else if (promedio == 3) {
          promedioLetra = "A";
      } else if (promedio == 2) {
          promedioLetra = "B";
      } else {
          promedioLetra = "C";
      }
      return promedioLetra;
      
  }
  document.addEventListener('DOMContentLoaded', function () {
    const filas = document.querySelectorAll('.user-table tbody tr');

    filas.forEach(fila => {
        calcularPromedio(fila); // Calcular el promedio para cada fila al cargar la página
        const selectores = fila.querySelectorAll('select[name^="notas["]');

        selectores.forEach(selector => {
            selector.addEventListener('change', function () {
                calcularPromedio(fila);
            });
        });
    });
});



    function mostrarConsola() {

        const idperiodo = document.getElementById('idperiodo').value;
        const idNivel = document.getElementById('idNivel').value;
        const idGrado = document.getElementById('idGrado').value;
        const idSeccion = document.getElementById('idSeccion').value;
        const idCurso = document.getElementById('idCurso').value;
        const codDocente = document.getElementById('codDocenteN1').value;
        const idcapacidad = document.getElementById('idcapacidad').value;
        const idtrimestre = document.getElementById('idtrimestre').value;

        var elementosCapacidad = document.querySelectorAll('.capacidad-select');
        var alumnos = [];
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

        console.log('Periodo:', idperiodo);
        console.log('Grado:', idGrado);
        console.log('Seccion:', idSeccion);
        console.log('Docente:', codDocente);
        console.log('Curso:', idCurso);
        console.log('Trimestre:', idtrimestre);
        console.log('Lista de alumnos:', alumnos);


        const data = {
        idperiodo,
        idGrado,
        idSeccion,
        idCurso,
        idtrimestre,
        codDocente,
        alumnos,
    };
        var url = '/actualizarNotas'; // Ajusta la URL según tu configuración

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(result => {
            console.log(result);
            alert("Notas actualizadas con éxito");
        })
        .catch(error => {
            console.error('Error al guardar las notas:', error);
        });
    };

</script>
@endsection












