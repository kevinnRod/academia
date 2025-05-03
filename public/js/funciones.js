function mostrarGrados() {
    var nivelId = document.getElementById('idNivel').value;
    var gradoSelect = document.getElementById('idGrado');
    gradoSelect.innerHTML = '';
  
    // Agregar la opción "--Grado--" como la primera opción
    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.text = '--Grado--';
    gradoSelect.appendChild(defaultOption);
  
    if (nivelId !== '') {
      var url = '/obtenerGradosPorNivel/' + nivelId;
      fetch(url)
        .then(response => response.json())
        .then(data => {
          data.forEach(grado => {
            var option = document.createElement('option');
            option.value = grado.idGrado;
            option.text = grado.grado;
            gradoSelect.appendChild(option);
          });
        })
        .catch(error => {
          console.log('Error al obtener los grados:', error);
        });
    }
}

function mostrarDocente() {
    var codDocente = document.getElementById('codDocente').value;
  
    var xhrDocente = new XMLHttpRequest();
    xhrDocente.open('GET', '/obtenerDocente/' + codDocente);
    xhrDocente.onreadystatechange = function() {
      if (xhrDocente.readyState === 4 && xhrDocente.status === 200) {
        var docente = JSON.parse(xhrDocente.responseText);
        var inputDocente = document.getElementById('docente');
        inputDocente.value = docente.apellidos + ', ' + docente.nombres;
  
        var xhrNivel = new XMLHttpRequest();
        xhrNivel.open('GET', '/obtenerNivel/' + docente.idNivel);
        xhrNivel.onreadystatechange = function() {
          if (xhrNivel.readyState === 4 && xhrNivel.status === 200) {
            var nivel = JSON.parse(xhrNivel.responseText);
            var inputNivel = document.getElementById('nivel');
            inputNivel.value = nivel.nivel;
  
            var xhrGrados = new XMLHttpRequest();
            xhrGrados.open('GET', '/obtenerGradosPorNivel/' + docente.idNivel);
            xhrGrados.onreadystatechange = function() {
              if (xhrGrados.readyState === 4 && xhrGrados.status === 200) {
                var grados = JSON.parse(xhrGrados.responseText);
                var selectGrados = document.getElementById('idGrado');
                selectGrados.innerHTML = '';
  
                var optionDefault = document.createElement('option');
                optionDefault.value = '';
                optionDefault.textContent = '--Grado--';
                selectGrados.appendChild(optionDefault);

                var selectSeccion = document.getElementById('idSeccion');
                selectSeccion.innerHTML = '';
  
                var optionDefault = document.createElement('option');
                optionDefault.value = '';
                optionDefault.textContent = '--Seccion--';
                selectSeccion.appendChild(optionDefault);
  
                grados.forEach(function(grado) {
                  var optionGrado = document.createElement('option');
                  optionGrado.value = grado.idGrado;
                  optionGrado.textContent = grado.grado;
                  selectGrados.appendChild(optionGrado);
                });
              }
            };
            xhrGrados.send();
          }
        };
        xhrNivel.send();
  
        var xhrCursos = new XMLHttpRequest();
        xhrCursos.open('GET', '/obtenerCursosPorNivel/' + docente.idNivel);
        xhrCursos.onreadystatechange = function() {
          if (xhrCursos.readyState === 4 && xhrCursos.status === 200) {
            var cursos = JSON.parse(xhrCursos.responseText);
            var selectCursos = document.getElementById('idCurso');
            selectCursos.innerHTML = '';
  
            var optionDefault = document.createElement('option');
            optionDefault.value = '';
            optionDefault.textContent = '--Curso--';
            selectCursos.appendChild(optionDefault);
  
            cursos.forEach(function(curso) {
              var optionCurso = document.createElement('option');
              optionCurso.value = curso.idCurso;
              optionCurso.textContent = curso.curso;
              selectCursos.appendChild(optionCurso);
            });
          }
        };
        xhrCursos.send();
  
        var xhrDocenteCurso = new XMLHttpRequest();
        xhrDocenteCurso.open('GET', '/obtenerDocenteCurso/' + codDocente);
        xhrDocenteCurso.onreadystatechange = function() {
          if (xhrDocenteCurso.readyState === 4 && xhrDocenteCurso.status === 200) {
            var docenteCurso = JSON.parse(xhrDocenteCurso.responseText);
            var tabla = document.getElementsByClassName('table user-table')[0];
            tabla.getElementsByTagName('tbody')[0].innerHTML = '';
  
            if (docenteCurso.length > 0) {
              docenteCurso.forEach(function(curso) {
                var fila = document.createElement('tr');
  
                var codigo = document.createElement('td');
                codigo.textContent = curso.curso.codCurso;
                fila.appendChild(codigo);
  
                var nombre = document.createElement('td');
                nombre.textContent = curso.curso.curso;
                fila.appendChild(nombre);
  
                var grado = document.createElement('td');
                grado.textContent = curso.grado.grado;
                fila.appendChild(grado);
                
                var seccion = document.createElement('td');
                seccion.textContent = curso.seccion.seccion;
                fila.appendChild(seccion);
  
                tabla.getElementsByTagName('tbody')[0].appendChild(fila);
              });
            } else {
              var fila = document.createElement('tr');
              var celda = document.createElement('td');
              celda.setAttribute('colspan', '4');
              celda.textContent = 'No hay registros';
              fila.appendChild(celda);
              tabla.getElementsByTagName('tbody')[0].appendChild(fila);
            }
          }
        };
        xhrDocenteCurso.send();

      }
    };
    xhrDocente.send();
}

function mostrarSeccion() {
    var gradoId = document.getElementById('idGrado').value;
    var idperiodo = document.getElementById('idperiodo').value;
    var seccionSelect = document.getElementById('idSeccion');
    seccionSelect.innerHTML = '';
  
    // Agregar la opción "--Seccion--" como la primera opción
    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.text = '--Seccion--';
    seccionSelect.appendChild(defaultOption);
  
    if (gradoId !== '') {
      var url = '/obtenerSeccionesPorGrado/' + gradoId + '/' + idperiodo;
      fetch(url)
        .then(response => response.json())
        .then(data => {
          data.forEach(seccion => {
            var option = document.createElement('option');
            option.value = seccion.idSeccion;
            option.text = seccion.seccion;
            seccionSelect.appendChild(option);
          });
        })
        .catch(error => {
          console.log('Error al obtener los grados:', error);
        });
    }
}

function mostrarCursoPorNivel() {
    var nivelId = document.getElementById('idNivel').value;
    
    var cursoSelect = document.getElementById('idCurso');
    cursoSelect.innerHTML = '';


  
    // Agregar la opción "--Curso--" como la primera opción
    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.text = '--Curso--';
    cursoSelect.appendChild(defaultOption);

    var tabla = document.getElementsByClassName('table user-table')[0];
    var tbody = tabla.getElementsByTagName('tbody')[0];
    tbody.innerHTML = '';
  
    if (nivelId !== '') {
      var url = '/obtenerCursosPorNivel/' + nivelId;
      fetch(url)
        .then(response => response.json())
        .then(data => {
          data.forEach(curso => {
            var option = document.createElement('option');
            option.value = curso.idCurso;
            option.text = curso.curso;
            cursoSelect.appendChild(option);
          });
        })
        .catch(error => {
          console.log('Error al obtener los grados:', error);
        });
    }
}

function mostrarCursoPorNivel1() {
  var nivelId = document.getElementById('idNivel').value;
  var cursoSelect = document.getElementById('idCurso');
  cursoSelect.innerHTML = '';
  // Agregar la opción "--Curso--" como la primera opción
  var defaultOption = document.createElement('option');
  defaultOption.value = '';
  defaultOption.text = '--Curso--';
  cursoSelect.appendChild(defaultOption);


  if (nivelId !== '') {
    var url = '/obtenerCursosPorNivel/' + nivelId;
    fetch(url)
      .then(response => response.json())
      .then(data => {
        data.forEach(curso => {
          var option = document.createElement('option');
          option.value = curso.idCurso;
          option.text = curso.curso;
          cursoSelect.appendChild(option);
        });
      })
      .catch(error => {
        console.log('Error al obtener los cursos:', error);
      });
  }
}





function mostrarNivel() {
    var idperiodo = document.getElementById('idperiodo').value;
    var nivelSelect = document.getElementById('idNivel');
    nivelSelect.innerHTML = '';
  
    // Agregar la opción "--Nivel--" como la primera opción
    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.text = '--Nivel Escolar--';
    nivelSelect.appendChild(defaultOption);
  
    if (idperiodo !== '') {
      var url = '/obtenerNivelPorAnyo'
      fetch(url)
        .then(response => response.json())
        .then(data => {
          data.forEach(nivel => {
            var option = document.createElement('option');
            option.value = nivel.idNivel;
            option.text = nivel.nivel;
            nivelSelect.appendChild(option);
          });
        })
        .catch(error => {
          console.log('Error al obtener los niveles:', error);
        });
    }

    mostrarTrimestre();
}






function mostrarTrimestre() {
  var idperiodo = document.getElementById('idperiodo').value;
  var trimestreSelect = document.getElementById('idtrimestre');
  trimestreSelect.innerHTML = '';

  // Agregar la opción "--Trimestre--" como la primera opción
  var defaultOption = document.createElement('option');
  defaultOption.value = '';
  defaultOption.text = '--Trimestre--';
  trimestreSelect.appendChild(defaultOption);

  if (idperiodo !== '') {
    var url = '/obtenerTrimestrePorPeriodo/' + idperiodo; // Corrección en la URL
    fetch(url)
      .then(response => response.json())
      .then(data => {
        data.forEach(trimestre => {
          var option = document.createElement('option');
          option.value = trimestre.idtrimestre;
          option.text = trimestre.idtrimestre;
          trimestreSelect.appendChild(option);
        });
      })
      .catch(error => {
        console.log('Error al obtener los trimestres:', error);
      });
  }
}

function mostrarCapacidadesPorCurso() {
  var idCurso = document.getElementById('idCurso').value;
  var capacidadSelect = document.getElementById('idcapacidad');
  capacidadSelect.innerHTML = '';

  // Agregar la opción "--Capacidad--" como la primera opción
  var defaultOption = document.createElement('option');
  defaultOption.value = '';
  defaultOption.text = '--Capacidad--';
  capacidadSelect.appendChild(defaultOption);

  if (idCurso !== '') {
      var url = '/obtenerCapacidadesPorCurso/' + idCurso;
      fetch(url)
          .then(response => response.json())
          .then(data => {
              data.forEach(capacidad => {
                  var option = document.createElement('option');
                  option.value = capacidad.idcapacidad;
                  option.text = capacidad.descripcion;
                  capacidadSelect.appendChild(option);
              });
          })
          .catch(error => {
              console.log('Error al obtener las capacidades:', error);
          });
  }
}



function mostrarDocentePorCurso() {
  var idCurso = document.getElementById('idCurso').value;
  var idperiodo = document.getElementById('idperiodo').value;
  var idSeccion = document.getElementById('idSeccion').value;
  var idGrado = document.getElementById('idGrado').value;
  var docenteInput = document.getElementById('docente');
  var capacidadSelect = document.getElementById('idCapacidad');
  
  if (idCurso !== '') {
    var url = '/obtenerDocentePorCurso/' + idCurso + '/' + idperiodo + '/' + idSeccion + '/' + idGrado;
    fetch(url)
      .then(response => response.json())
      .then(data => {
        // Verificar si se encontró un docente para el curso seleccionado
        if (data.apellidos != null) {
          var nombreDocente = data.apellidos + ', ' + data.nombres;
          docenteInput.value = nombreDocente;
        } else {
          docenteInput.value = '';
        }
      })
      .catch(error => {
        console.log('Error al obtener el docente:', error);
      });
    
    mostrarCapacidadesPorCurso();
  } else {
    docenteInput.value = '';
    capacidadSelect.innerHTML = '';
  }

}


function totalAlumnos() {
  var filasAlumnos = document.querySelectorAll('.user-table tbody tr');
  var totalAlumnos = filasAlumnos.length;

  // Verificar si hay una sola fila y esa fila contiene el mensaje "No hay registros"
  if (totalAlumnos === 1 && filasAlumnos[0].textContent.trim() === 'No hay registros') {
    totalAlumnos = 0; // Si solo hay un registro y es el mensaje, establece el total en 0
  }

  document.querySelector('#totalAlumnos').value = totalAlumnos;
}

// Llama a totalAlumnos al cargar la página para mostrar el valor inicial
totalAlumnos();
 


// Función para habilitar los campos de edición y mostrar el botón "Deshabilitar edición"
function habilitarCampos() {
  var selectores = document.querySelectorAll('.trimestre-select');
  selectores.forEach(function (selector) {
      selector.disabled = false;
  });


  // Mostrar el botón "Deshabilitar edición" y ocultar el botón "Colocar notas"
  document.querySelector('#colocarNotasBtn').style.display = 'none';
  document.querySelector('#deshabilitarEdicionBtn').style.display = 'inline-block';
  totalAlumnos()
}


// Función para deshabilitar los campos de edición
function deshabilitarCampos() {
  var selectores = document.querySelectorAll('.trimestre-select');
  selectores.forEach(function (selector) {
      selector.disabled = true;
  });


  // Ocultar el botón "Deshabilitar edición" y mostrar el botón "Colocar notas"
  document.querySelector('#colocarNotasBtn').style.display = 'inline-block';
  document.querySelector('#deshabilitarEdicionBtn').style.display = 'none';
  totalAlumnos()
}

function calcularPromedio(fila) {
  const selectores = fila.querySelectorAll('select[name^="notas["]');
  let sumaNotas = 0;
  let cantidadNotas = 0;

  let todasNotasLlenas = true; // Agregar una variable de control

  selectores.forEach(selector => {
      if (selector.value) {
          sumaNotas += convertirNota(selector.value);
          cantidadNotas++;
      } else {
          todasNotasLlenas = false; // Al menos una nota está vacía
      }
  });

  if (cantidadNotas > 0 && todasNotasLlenas) { // Calcular el promedio solo si todas las notas están llenas
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

    var csrftoken ="{{ csrf_token() }}";

    // Función para cargar tipos de ciclo según el periodo seleccionado
    function cargarTiposCiclo() {
        var idperiodo = document.getElementById('idperiodo').value;
        var tipoCicloSelect = document.getElementById('idtipociclo');
        tipoCicloSelect.innerHTML = '';

        // Agregar la opción "--Tipo de Ciclo--" como la primera opción
        var defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.text = '--Tipo de Ciclo--';
        tipoCicloSelect.appendChild(defaultOption);

        if (idperiodo !== '') {
            var url = '/cargar-tipos-ciclo/' + idperiodo;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    data.forEach(tiposCicloDescripcion => {
                            var option = document.createElement('option');
                            option.value = tiposCicloDescripcion.idtipociclo;
                            option.text = tiposCicloDescripcion.descripcion;
                            tipoCicloSelect.appendChild(option);
                        });

                    
                })
                .catch(error => {
                    console.log('Error al obtener los tipos de ciclo:', error);
                });
        }
    }

    function cargarAreas() {
    var idperiodo = document.getElementById('idperiodo').value;
    var idtipociclo = document.getElementById('idtipociclo').value;

    var areaSelect = document.getElementById('idarea');
    areaSelect.innerHTML = '';

    // Agregar la opción "--Área--" como la primera opción
    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.text = '--Área--';
    areaSelect.appendChild(defaultOption);

    if (idperiodo !== '' && idtipociclo !== '') {
        var url = `/cargar-areas/${idperiodo}/${idtipociclo}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                data.forEach(area => {
                    var option = document.createElement('option');
                    option.value = area.idarea;
                    option.text = area.descripcion;
                    areaSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.log('Error al obtener las áreas:', error);
            });
    }
  }

    function cargarCiclos() {
        var idperiodo = document.getElementById('idperiodo').value;
        var idtipociclo = document.getElementById('idtipociclo').value;
        var idarea = document.getElementById('idarea').value;

        var cicloSelect = document.getElementById('idciclo');
        cicloSelect.innerHTML = '';

        // Agregar la opción "--Ciclo--" como la primera opción
        var defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.text = '--Ciclo--';
        cicloSelect.appendChild(defaultOption);

        if (idperiodo !== '' && idtipociclo !== '' && idarea !== '') {
            var url = '/cargar-ciclos/' + idperiodo + '/' + idtipociclo + '/' + idarea;
            console.log(url);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    
                        data.forEach(ciclo => {
                            var option = document.createElement('option');
                            option.value = ciclo.idciclo;
                            option.text = ciclo.descripcion;
                            cicloSelect.appendChild(option);
                        });
                   
                })
                .catch(error => {
                    console.log('Error al obtener los ciclos:', error);
                });
        }
    }

    function cargarAulas() {
        var cicloId = document.getElementById('idciclo').value;
        console.log(cicloId);
        var aulaSelect = document.getElementById('idaula');
        aulaSelect.innerHTML = '';

        // Agregar la opción "--Aula--" como la primera opción
        var defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.text = '--Aula--';
        aulaSelect.appendChild(defaultOption);

        if (cicloId !== '') {
            var url = `/cargar-aulas/${cicloId}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.aulas && data.aulas.length > 0) {
                        data.aulas.forEach(aula => {
                            var option = document.createElement('option');
                            option.value = aula.idaula;
                            option.text = aula.descripcion;
                            aulaSelect.appendChild(option);
                        });
                    } else {
                        // Mensaje si no hay aulas disponibles
                        var noOption = document.createElement('option');
                        noOption.value = '';
                        noOption.text = 'No hay aulas disponibles';
                        aulaSelect.appendChild(noOption);
                    }
                })
                .catch(error => {
                    console.log('Error al obtener las aulas:', error);
                });
        }
    }
    function cargarCarreras() {
        var idarea = document.getElementById('idarea').value;

        var carreraSelect = document.getElementById('idcarrera');
        carreraSelect.innerHTML = '';

        // Agregar la opción "--Seleccionar Carrera--" como la primera opción
        var defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.text = '--Seleccionar Carrera--';
        carreraSelect.appendChild(defaultOption);

        if (idarea !== '') {
            var url = `/cargar-carreras/${idarea}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    data.forEach(carreras => {
                        var option = document.createElement('option');
                        option.value = carreras.idcarrera;
                        option.text = carreras.descripcion;
                        carreraSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.log('Error al obtener las carreras:', error);
                });
        }
    }
    
    function cargarAlumnos() {
      var cicloId = document.getElementById('idciclo').value;
      var aulaId = document.getElementById('idaula').value;
      var alumnosTableBody = document.getElementById('alumnos-table-body');
      var alumnosCountElement = document.getElementById('alumnos-count');
      
      // Limpiar la tabla de alumnos y el contador de alumnos
      alumnosTableBody.innerHTML = '';
      alumnosCountElement.innerHTML = '';
  
      if (cicloId !== '' && aulaId !== '') {
          var url = `/cargar-alumnos/${cicloId}/${aulaId}`;
          fetch(url)
              .then(response => response.json())
              .then(data => {
                  if (data.alumnos && data.alumnos.length > 0) {
                      // Mostrar el número de alumnos
                      alumnosCountElement.innerHTML = `Número de alumnos: ${data.alumnos.length}`;
  
                      data.alumnos.forEach(alumno => {
                          var row = document.createElement('tr');

                          row.innerHTML = `
                              <td>${alumno.numMatricula}</td>    
                              <td>${alumno.dniAlumno}</td>
                              <td>${alumno.apellidos}</td>
                              <td>${alumno.nombres}</td>
                              <td>${alumno.fechaNacimiento}</td>
                              <td>
                                <a href="${alumno.featured}" data-fancybox="gallery" data-caption="Foto del alumno">
                                    <img src="${alumno.featured}" alt="Foto del alumno" class="img-fluid" width="50px">
                                </a>
                              </td>

                             
                              <td>${alumno.idperiodo}</td>
                              <td>${alumno.tipo_ciclo_descripcion}</td>
                              <td>${alumno.area_descripcion}</td>
                              <td>${alumno.ciclo_descripcion}</td>
                              <td>${alumno.aula_descripcion}</td>
                              
                              
                              
                          `;
                          alumnosTableBody.appendChild(row);
                      });
                  } else {
                      alumnosCountElement.innerHTML = `Número de alumnos: 0`;
  
                      var row = document.createElement('tr');
                      row.innerHTML = '<td colspan="10">No hay alumnos disponibles</td>';
                      alumnosTableBody.appendChild(row);
                  }
              })
              .catch(error => {
                  console.log('Error al obtener los alumnos:', error);
              });
      }
  }
  
  function cargarDocentes(url) {
    var aulaId = document.getElementById('idaula').value;
    var docentesTableBody = document.getElementById('docentes-table-body');
    var docentesCountElement = document.getElementById('docentes-count');

    // Limpiar la tabla de docentes y el contador de docentes
    docentesTableBody.innerHTML = '';
    docentesCountElement.innerHTML = '';

    if (aulaId !== '') {
        fetch(url || `/cargar-docentes/${aulaId}`)
            .then(response => response.json())
            .then(data => {
                if (data.data && data.data.length > 0) {
                    // Mostrar el número de docentes
                    docentesCountElement.innerHTML = `Docentes asignados al aula: ${data.total}`;

                    data.data.forEach(docente => {
                        var row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${docente.codDocente}</td>
                            <td>${docente.nombreCompleto}</td>
                            <td>${docente.curso}</td>
                        `;
                        docentesTableBody.appendChild(row);
                    });

                    // Mostrar la paginación
                    mostrarPaginacion(data);
                } else {
                    docentesCountElement.innerHTML = `Número de docentes: 0`;

                    var row = document.createElement('tr');
                    row.innerHTML = '<td colspan="3">No hay docentes disponibles</td>';
                    docentesTableBody.appendChild(row);
                }
            })
            .catch(error => {
                console.log('Error al obtener los docentes:', error);
            });
    }
}

function mostrarPaginacion(data) {
    var paginationContainer = document.querySelector('.pagination-container');
    paginationContainer.innerHTML = '';

    // Crear la navegación de la paginación
    var pagination = document.createElement('nav');
    pagination.setAttribute('aria-label', 'Page navigation');
    pagination.innerHTML = `
        <ul class="pagination">
            ${data.prev_page_url ? `<li class="page-item"><a class="page-link" href="#" onclick="cargarDocentes('${data.prev_page_url}'); return false;">Anterior</a></li>` : ''}
            ${data.current_page > 1 ? `<li class="page-item"><a class="page-link" href="#" onclick="cargarDocentes('/cargar-docentes/${idaula}?page=${data.current_page - 1}'); return false;">&laquo;</a></li>` : ''}
            ${Array.from({ length: data.total_pages }, (_, i) => i + 1).map(page => `
                <li class="page-item ${page === data.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="cargarDocentes('/cargar-docentes/${idaula}?page=${page}'); return false;">${page}</a>
                </li>
            `).join('')}
            ${data.current_page < data.total_pages ? `<li class="page-item"><a class="page-link" href="#" onclick="cargarDocentes('/cargar-docentes/${idaula}?page=${data.current_page + 1}'); return false;">&raquo;</a></li>` : ''}
            ${data.next_page_url ? `<li class="page-item"><a class="page-link" href="#" onclick="cargarDocentes('${data.next_page_url}'); return false;">Siguiente</a></li>` : ''}
        </ul>
    `;
    paginationContainer.appendChild(pagination);
}



function mostrarHorario() {
  var aulaId = document.getElementById('idaula').value;
  var horarioContainer = document.getElementById('horario-container');

  if (aulaId) {
      fetch(`/aula/${aulaId}/horario`)
          .then(response => response.json())
          .then(data => {
              if (data.horario) {
                  horarioContainer.innerHTML = `
                      <a href="${data.horario}" data-fancybox="horario" data-caption="Horario del Aula">
                        <img src="${data.horario}" alt="Horario del Aula" style="width: 150px; height: auto; cursor: pointer;">
                      </a>`;
              } else {
                  horarioContainer.innerHTML = '<p>No se ha encontrado una imagen para el horario.</p>';
              }
          })
          .catch(error => {
              console.error('Error:', error);
              horarioContainer.innerHTML = '<p>Error al cargar la imagen del horario.</p>';
          });
  } else {
      horarioContainer.innerHTML = '';
  }
}








  document.addEventListener('DOMContentLoaded', function () {
    const filas = document.querySelectorAll('.user-table tbody tr');

    filas.forEach(fila => {
        const selectores = fila.querySelectorAll('select[name^="notas["]');

        selectores.forEach(selector => {
            selector.addEventListener('change', function () {
                calcularPromedio(fila);
            });
        });
    });
});

