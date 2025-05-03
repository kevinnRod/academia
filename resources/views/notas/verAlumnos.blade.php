@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Notas de Alumnos</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item">
        <a href="{{ route('notas.index') }}">Ver Notas</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Notas de Alumnos</li>
</ul>
@endsection

@section('contenido')
    <div class="row text-black">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-12">
                        <h4 class="card-title">Notas de Alumnos</h4>
                    </div>
                    <div class="col-12">
                        <form class="form-inline my-2 my-lg-0 float-right" role="search">
                            <input name="nombreApellido" class="form-control me-2" type="search" placeholder="Buscar por nombre o apellido" aria-label="Search" value="{{ $nombreApellido }}">
                            <button class="btn btn-success" type="submit">Buscar</button>
                        </form>
                    </div>

                    <div id="mensaje"></div>




                    <div class="row">
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Trimestre:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->trimestre->descripcion }}" disabled>
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->idtrimestre }}" id="idtrimestreN" name="idtrimestreN" hidden disabled>

                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Periodo:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->idperiodo }}" disabled>
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->idperiodo }}" hidden id="idperiodoN" name="idperiodoN" disabled>
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Nivel:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->curso->nivel->nivel }}"disabled>
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Curso:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->curso->curso }}" disabled>
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->idCurso }}" id="idCursoN" name="idCursoN" hidden disabled>
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Grado:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->grado->grado }}"  disabled>
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->idGrado}}" id="idGradoN" name="idGradoN" hidden disabled>
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Sección:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->seccion->seccion }}" disabled>
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->idSeccion }}" id="idSeccionN" name="idSeccionN" hidden disabled>
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="col-md-12 mb-0">Docente:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->docente->nombres }} {{ $alumnosNotas->first()->docente->apellidos }}" disabled>
                                <input type="text" class="form-control" value="{{ $alumnosNotas->first()->codDocente}}" id="codDocenteN" name="codDocenteN" hidden disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col p-3">
                            <button class="btn btn-primary" id="colocarNotasBtn" onclick="habilitarCampos()">Colocar notas</button>
                            <button class="btn btn-danger" id="deshabilitarEdicionBtn" onclick="deshabilitarCampos()" style="display: none;">Deshabilitar edición</button>
                        </div>
                    </div>

                    <table class="table user-table">
                        <thead>
                            <tr>
                                <th class="border-top-0">Nro</th>
                                <th class="border-top-0">Alumno</th>
                                @foreach ($capacidad as $itemCapacidad)
                                    <th class="border-top-0">{{ $itemCapacidad->descripcion }}</th>
                                @endforeach
                                <th class="border-top-0">Promedio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($alumnosNotas->isEmpty())
                                <tr>
                                    <td colspan="{{ count($capacidad) + 2 }}">No hay registros</td>
                                </tr>
                            @else
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
        </div>

        <div class="col-6 form-group">
                        <label class="col-md-12 mb-0">Total de Alumnos:</label>
                        <div class="col-md-3 text-center">
                            <input type="text" id="totalAlumnos" name="totalAlumnos" class="form-control form-control-line text-center" disabled>
                        </div>
                    </div>
        <div class="row p-3">
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary" onclick="guardarNotas()">Guardar Notas</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <a href="javascript:history.back()" class="btn btn-danger">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
    
@endsection


@section('script')
<script>



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
var csrfToken = "{{ csrf_token() }}";


function guardarNotas() {
    let cont = 0;

    const idperiodo = document.getElementById('idperiodoN').value;
    const idGrado = document.getElementById('idGradoN').value;
    const idSeccion = document.getElementById('idSeccionN').value;
    const idCurso = document.getElementById('idCursoN').value;
    const idtrimestre = document.getElementById('idtrimestreN').value;
    const codDocente = document.getElementById('codDocenteN').value;

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
    }    




</script>
   
   
@endsection





