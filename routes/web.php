<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AnyoEscolarController;
use App\Http\Controllers\GradoController;

use App\Http\Controllers\SeccionController;

use App\Http\Controllers\AulaController;
use App\Http\Controllers\CapacidadController;
use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\DocenteCursoController;
use App\Http\Controllers\FuncionesController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\TrimestreController;
use App\Http\Controllers\TipoCicloController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\AulaController2;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\CursooController;
use App\Http\Controllers\CatedraController;
use App\Http\Controllers\TipoExamenController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\NotaExamenController;
use App\Http\Controllers\RespuestaCorrectaController;
use App\Http\Controllers\ExamenIAController;










/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('login');
});*/

// Login:
Route::get('/', [UserController::class,'showLogin']);
Route::post('/identificacion', [UserController::class,'verificalogin'])->name('identificacion');
Route::post('/logout',[UserController::class,'salir'])->name('logout');
Route::get('/seleccionar-periodo', [HomeController::class, 'seleccionarPeriodo'])->name('seleccionar-periodo');
// Ruta para procesar la selección de período (método POST)
Route::post('/procesar-seleccion-periodo', [HomeController::class, 'procesarSeleccionPeriodo'])->name('procesar-seleccion-periodo');

// Ruta para mostrar la página principal (método GET)
Route::get('/home/{periodo?}', [HomeController::class, 'index'])->name('home');


// Año Escolar:
Route::resource('/periodo', AnyoEscolarController::class);
Route::get('cancelarAnyo', function () {
    return redirect()->route('periodo.index')->with('datos','Acción Cancelada ..!');
})->name('cancelarAnyo');
Route::get('periodo/{id}/confirmar',[AnyoEscolarController::class,'confirmar'])->name('periodo.confirmar');

Route::get('/aulas',[AnyoEscolarController::class,'general'])->name('aulas.general');

//Grados:
Route::get('/{id}/aulas',[AulaController::class,'index'])->name('aulas.index');
Route::get('/{id}/aulas/create',[AulaController::class,'create'])->name('aulas.create');
Route::post('/{id}/aulas/store', [AulaController::class,'store'])->name('aulas.store');
Route::get('/{id}/aulas/edit',[AulaController::class,'edit'])->name('aulas.edit');
Route::post('/{idA}/aulas/{idS}/update',[AulaController::class,'update'])->name('aulas.update');
Route::get('aulas/{id}/confirmar',[AulaController::class,'confirmar'])->name('aulas.confirmar');
Route::post('/aulas/{id}/destroy',[AulaController::class,'destroy'])->name('aulas.destroy');
Route::get('/{id}/aulas/cancelar', [AulaController::class,'cancelar'])->name('cancelarAula');

// Docentes:
Route::resource('/docentes', DocenteController::class);
Route::get('cancelarDocentes', function () {
    return redirect()->route('docentes.index')->with('datos','Acción Cancelada ..!');
})->name('cancelarDocentes');
Route::get('docentes/{id}/confirmar',[DocenteController::class,'confirmar'])->name('docentes.confirmar');
Route::get('docentes/{id}/{codDocente}/{idCurso}/{idperiodo}/confirmar', [DocenteCursoController::class, 'confirmar'])->name('docenteCurso.confirmar');

// Cursos:
// Route::resource('/cursos', CursoController::class);
// Route::get('cancelarCurso', function () {
//     return redirect()->route('cursos.index')->with('datos','Acción Cancelada ..!');
// })->name('cancelarCurso');
// Route::get('cursos/{id}/confirmar',[CursoController::class,'confirmar'])->name('cursos.confirmar');

//Capacidades del Cursos:
Route::resource('/capacidades', CapacidadController::class);
Route::get('cancelarCapacidad', function () {
    return redirect()->route('capacidades.index')->with('datos','Acción Cancelada ..!');
})->name('cancelarCapacidad');
Route::get('capacidades/{id}/confirmar',[CapacidadController::class,'confirmar'])->name('capacidades.confirmar');



//Docente_Cursos:
Route::resource('/docenteCurso', DocenteCursoController::class);
Route::get('/docenteCurso/editar/{id}/{codDocente}/{idCurso}/{idperiodo}', [DocenteCursoController::class, 'editar'])->name('docenteCurso.editar');
Route::put('/docenteCurso/update/{id}/{codDocente}/{idCurso}/{idperiodo}', [DocenteCursoController::class, 'update'])->name('docenteCurso.update');
Route::get('/docenteCurso/confirmar/{id}/{codDocente}/{idCurso}/{idperiodo}', [DocenteCursoController::class, 'confirmar'])
    ->name('docenteCurso.confirmar');

Route::delete('/docenteCurso/eliminar/{id}/{codDocente}/{idCurso}/{idperiodo}', [DocenteCursoController::class, 'eliminar'])
    ->name('docenteCurso.eliminar');
//Route::get('/docenteCurso',[DocenteCursoController::class,'index'])->name('docenteCurso.index');
//Route::post('/docenteCurso/store', [DocenteCursoController::class, 'store'])->name('docenteCurso.store');


// Matricula:
Route::resource('/matriculas', MatriculaController::class);
Route::get('cancelarMatricula', function () {
    return redirect()->route('matriculas.index')->with('datos','Acción Cancelada ..!');
})->name('cancelarMatricula');
// Route::get('matriculas/{id}/confirmar',[MatriculaController::class, 'confirmar'])->name('matriculas.confirmar');
Route::get('/matriculas/lista/{numMatricula}', [MatriculaController::class, 'pdf'])->name('lista.pdf');

// Alumnos:
Route::resource('/alumnos', AlumnoController::class);

//Notas:
Route::resource('/notas', NotasController::class);
Route::get('/ver', [NotasController::class, 'ver'])->name('notas.ver');
Route::get('/reporte', [NotasController::class, 'reporte'])->name('notas.reporte');
Route::post('/reporte/enviar', [NotasController::class, 'mostrarReporte'])->name('notas.reporte.enviar');



Route::get('/obtenerGradosPorNivel/{idNivel}', [FuncionesController::class,'PorNivel']);
Route::get('/obtenerDocente/{codDocente}', [FuncionesController::class,'VerDocente']);
Route::get('/obtenerCursosPorNivel/{idNivel}', [FuncionesController::class,'VerCurso']);
Route::get('/obtenerNivel/{idNivel}', [FuncionesController::class,'VerNivel']);
Route::get('/obtenerSeccionesPorGrado/{idGrado}/{idperiodo}', [FuncionesController::class,'VerSeccion']);
Route::get('/obtenerDocenteCurso/{codDocente}', [FuncionesController::class,'obtenerDocenteCurso']);

Route::get('/obtenerCapacidadesPorCurso/{idcapacidad}', [FuncionesController::class,'obtenerCapacidadesPorCurso']);


Route::get('/obtenerTrimestrePorPeriodo/{idtrimestre}', [FuncionesController::class, 'obtenerTrimestrePorPeriodo']);

Route::get('/obtenerNivelPorAnyo', [FuncionesController::class,'NivelPorAnyo']);
Route::get('/obtenerDocentePorCurso/{idCurso}/{numAnyo}/{idSeccion}/{idGrado}', [FuncionesController::class, 'obtenerDocentePorCurso']);

Route::post('/guardarNotas', [NotasController::class, 'guardarNotas']);
Route::post('/actualizarNotas', [NotasController::class, 'actualizarNotas']);
Route::get('/notas/eliminar/{idperiodo}/{idCurso}/{idGrado}/{idSeccion}/{idtrimestre}', [NotasController::class, 'eliminar'])->name('notas.eliminar');

Route::get('/notas/alumnos/{periodo}/{curso}/{grado}/{seccion}/{trimestre}', [NotasController::class, 'verAlumnosPorFiltros'])->name('notas.verAlumnosPorFiltros');


Route::get('/notas/pdf/{periodo}/{curso}/{grado}/{seccion}/{trimestre}',  [NotasController::class, 'pdfPorCurso'])->name('notas.notasPdfPorCurso');

Route::get('/generar-informe-pdf', [NotasController::class, 'generarInformePDF'])->name('notas.informepdf');
Route::get('/generar-informe-trimestre', [NotasController::class, 'informetrimestre'])->name('notas.informetrimestre');
Route::get('/boletaDeNotas', [NotasController::class, 'boletaDeNotas'])->name('notas.boleta');
Route::get('/boletaTrimestre/{dniAlumno}', [NotasController::class, 'boletaTrimestre'])->name('notas.boletaTrimestre');
Route::get('/boletaAnual/{dniAlumno}', [NotasController::class, 'boletaAnual'])->name('notas.boletaAnual');



Route::resource('tipociclo', TipoCicloController::class);
Route::get('tipociclo/confirmar/{id}', [TipoCicloController::class, 'confirmar'])->name('tipociclo.confirmar');
Route::resource('area', AreaController::class);
Route::get('area/confirmar/{id}', [AreaController::class, 'confirmar'])->name('area.confirmar');
Route::resource('carrera', CarreraController::class)->except(['show']); 

Route::get('carrera/confirmar/{carrera}', [CarreraController::class, 'confirmar'])
    ->name('carrera.confirmar');

Route::resource('aula', AulaController2::class)->except(['show']); 

Route::get('aula/confirmar/{aula}', [AulaController2::class, 'confirmar'])
    ->name('aula.confirmar');

    
Route::resource('ciclo', CicloController::class)->except(['show']); // Exclude 'show' if not needed

Route::get('ciclo/confirmar/{ciclo}', [CicloController::class, 'confirmar'])
    ->name('ciclo.confirmar');



    Route::get('/cargar-ciclos/{idperiodo}/{idtipociclo}/{idarea}', [FuncionesController::class, 'cargarCiclos']);

    // Ruta para cargar aulas según ciclo
    Route::get('/cargar-aulas/{cicloId}', [FuncionesController::class, 'cargarAulas'])->name('cargar.aulas');
    Route::get('/cargar-tipos-ciclo/{idperiodo}', [FuncionesController::class, 'cargarTiposCiclo'])->name('cargar-tipos-ciclo');
    Route::get('/cargar-areas/{idperiodo}/{idtipociclo}', [FuncionesController::class, 'cargarAreas'])->name('cargar-areas');
    Route::get('/cargar-carreras/{idarea}', [FuncionesController::class, 'cargarCarreras'])->name('cargar-carreras');

    Route::get('matriculas/confirmar/{numMatricula}', [MatriculaController::class, 'confirmar'])
    ->name('matriculas.confirmar');

    // Ruta para mostrar el formulario de edición
Route::get('/matriculas/{numMatricula}/edit', [MatriculaController::class, 'edit'])->name('matriculas.edit');

// Ruta para actualizar la matrícula
Route::put('/matriculas/{numMatricula}', [MatriculaController::class, 'update'])->name('matriculas.update');

Route::resource('/cursoos', CursooController::class);
Route::get('cancelarCurso', function () {
    return redirect()->route('cursoos.index')->with('datos','Acción Cancelada ..!');
})->name('cancelarCurso');
Route::get('cursoos/{id}/confirmar',[CursooController::class,'confirmar'])->name('cursoos.confirmar');
//Route::post('/guardarNota', [FuncionesController::class,'guardarNota']);

Route::resource('/catedra', CatedraController::class);
Route::get('cancelarCatedra', function () {
    return redirect()->route('catedra.index')->with('datos', 'Acción Cancelada ..!');
})->name('cancelarCatedra');
Route::get('catedra/{id}/confirmar', [CatedraController::class, 'confirmar'])->name('catedra.confirmar');


Route::resource('tipoexamen', TipoExamenController::class);
// Ruta para confirmar la eliminación
Route::get('tipoexamen/{id}/confirmar', [TipoExamenController::class, 'confirmar'])->name('tipoexamen.confirmar');

Route::resource('examen', ExamenController::class);

// Ruta para confirmar la eliminación
Route::get('examen/{id}/confirmar', [ExamenController::class, 'confirmar'])->name('examen.confirmar');

//MATRICULA
Route::get('/cargar-docentes/{idaula}', [MatriculaController::class, 'cargarDocentes'])->name('cargar-docentes');
Route::get('/aula/{idaula}/horario', [AulaController2::class, 'getHorario'])->name('aula.getHorario');
Route::get('/matriculas/{numMatricula}/ficha', [MatriculaController::class, 'generarFichaPDF'])->name('matriculas.ficha.pdf');



//NOTAS

Route::get('notaExamen/{id}/confirmar', [NotaExamenController::class, 'confirmar'])->name('notaExamen.confirmar');
// Route::post('/notaExamen/{idexamen}', [NotaExamenController::class, 'store'])->name('notaExamen.store');
Route::get('/notaExamen/imprimir/{idexamen}', [NotaExamenController::class, 'imprimir'])->name('notaExamen.imprimir');
Route::get('/pdf-sin-formato/{idexamen}', [NotaExamenController::class, 'generarPdfSinFormato'])->name('pdf.sinFormato');
Route::get('/grafico-circular/{idexamen}', [NotaExamenController::class, 'generarGraficoCircular'])->name('grafico.circular');

Route::get('notaExamen/notasAlumno', [NotaExamenController::class, 'notasAlumnos'])->name('notaExamen.notasAlumno');
Route::get('notaExamen/reportes', [NotaExamenController::class, 'reportes'])->name('notaExamen.reportes');
Route::resource('notaExamen', NotaExamenController::class);

Route::get('/datos-grafico/{idexamen}', [NotaExamenController::class, 'generarDatosGraficoCircular']);


Route::get('/notaExamen/verNotas/{dniAlumno}', [NotaExamenController::class, 'verNotas'])->name('notaExamen.verNotas');
Route::get('/nota-examen/{idaula}/{dniAlumno}', [NotaExamenController::class, 'verNotasAulaAlumno'])->name('notaExamen.verNotasAulaAlumno');
Route::get('/grafico-notas/{dniAlumno}', [NotaExamenController::class, 'graficoNotas'])->name('grafico.notas');
Route::get('/grafico-notas-alumnoLineal/{dniAlumno}', [NotaExamenController::class, 'graficoNotasAlumnoLineal'])->name('grafico.notas.alumnoLineal');


Route::get('/cargar-alumnos/{cicloId}/{aulaId}', [AlumnoController::class, 'cargarAlumnos']);



Route::post('/notaExamen/generar-pdf/{dniAlumno}', [NotaExamenController::class, 'generarPdf'])->name('notaExamen.generarPdf');
Route::get('/examen/{id}/respuestas-correctas', [RespuestaCorrectaController::class, 'editPorExamen'])->name('respuestas_correctas.edit');
Route::put('/examen/{id}/respuestas-correctas', [RespuestaCorrectaController::class, 'updatePorExamen'])->name('respuestas_correctas.updatePorExamen');

Route::get('/chat-examen', function () {
    return view('chatbot');
});

Route::post('/generar-preguntas', [ExamenIAController::class, 'generarPreguntas'])->middleware('auth');
