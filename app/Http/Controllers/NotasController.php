<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Alumno_Seccion;
use App\Models\Periodo;
use App\Models\Curso;
use App\Models\Capacidad;

use App\Models\Curso_Capacidad;
use App\Models\Docente;
use App\Models\Docente_Curso;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\Nivel;
use App\Models\Nota;
use App\Models\Trimestre;
use Illuminate\Support\Facades\DB;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;

use App\Models\Seccion;
use Illuminate\Http\Request;

class NotasController extends Controller
{
    const PAGINATION = 10;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $nivelEscolar = Nivel::all();
        $periodo = Periodo::all();
        $grado = Grado::all();
        $seccion = Seccion::where('estado','=','1')->get();
        $trimestre = Trimestre::where('estado','=','1')->get();
        $cursos = Curso::where('estado','=','1')->get();
        $capacidad = Capacidad::where('estado','=','1')->get();
        $request = null;
        $docente = null;

        return view('notas.index', compact('nivelEscolar', 'periodo','grado', 'seccion', 'cursos', 'capacidad', 'request', 'docente', 'trimestre'));
    }

    public function reporte()
    {
        //
        $nivelEscolar = Nivel::all();
        $periodo = Periodo::all();
        $grado = Grado::all();
        $seccion = Seccion::where('estado','=','1')->get();
        $trimestre = Trimestre::where('estado','=','1')->get();
        $cursos = Curso::where('estado','=','1')->get();
        $capacidad = Capacidad::where('estado','=','1')->get();
        $request = null;
        $docente = Docente::where('estado','=','1')->get();
        

        return view('notas.reporte', compact('nivelEscolar', 'periodo','grado', 'seccion', 'cursos', 'capacidad', 'request', 'docente', 'trimestre'));
    }

    public function mostrarReporte(Request $request)
    {
    
        $data = request()->validate([
            'idcapacidad' => 'required'
        ],
        [
            'idcapacidad' => 'Seleccione una capacidad'
        ]);
    
        $alumnos = Matricula::where('idperiodo', '=', $request->idperiodo)
            ->where('idGrado', '=', $request->idGrado)
            ->where('idSeccion', '=', $request->idSeccion)
            ->get();
        $trimestre = Trimestre::all();
    
        $nivelEscolar = Nivel::all();
        $periodo = Periodo::all();
        $grado = Grado::where('idNivel', '=', $request->idNivel)->get();
        $seccion = Seccion::where('estado', '=', '1')->where('idGrado', '=', $request->idGrado)->get();
        $cursos = Curso::where('estado', '=', '1')->where('idNivel', '=', $request->idNivel)->get();
        $capacidad = Capacidad::where('idCurso', '=', $request->idCurso)->get();

        // \DB::enableQueryLog();
        $docente_curso = Docente_Curso::where('estado', '=', '1')
            ->where('idperiodo', '=', $request->idperiodo)
            ->where('idCurso', '=', $request->idCurso)
            ->where('idGrado', '=', $request->idGrado)
            ->where('idSeccion', '=', $request->idSeccion)
            ->with(['anyoescolar', 'grado', 'seccion', 'curso'])
            ->first();

        // Luego, puedes acceder al docente relacionado de esta manera:
        if ($docente_curso) {
            $docente = $docente_curso->docente;
        }

        if ($docente === null) {
            $docente = null;
        }
        // \Log::info(\DB::getQueryLog());

        $alumnosNotas = Nota::where('idperiodo', '=', $request->idperiodo)
            ->where('idCurso', '=', $request->idCurso)
            ->where('idGrado', '=', $request->idGrado)
            ->where('idSeccion', '=', $request->idSeccion)
            ->where('idtrimestre', '=', $request->idtrimestre)
            ->with(['curso', 'grado', 'seccion', 'docente', 'trimestre', 'capacidad']) // Cargar relación capacidad
            ->get();

        

        $alumnosPorCapacidad = [];
        foreach ($alumnosNotas as $nota) {
            $alumnoId = $nota->dniAlumno;
            $capacidadId = $nota->idcapacidad;
            $notaValor = $nota->nota;

            if (!isset($alumnosPorCapacidad[$alumnoId])) {
                $alumnosPorCapacidad[$alumnoId] = [];
            }

            if (!isset($alumnosPorCapacidad[$alumnoId][$capacidadId])) {
                $alumnosPorCapacidad[$alumnoId][$capacidadId] = $notaValor;
            }
        }

        if ($alumnosNotas->isEmpty()) {
            // No se encontraron registros
            return view('notas.reporte', compact('nivelEscolar', 'periodo', 'grado', 'seccion', 'cursos', 'capacidad', 'alumnos', 'docente','request', 'trimestre', 'alumnosNotas', 'capacidad', 'alumnosPorCapacidad'))
                ->with('error', 'No se encontraron registros.');
        }else{
        return view('notas.reporte', compact('nivelEscolar', 'periodo', 'grado', 'seccion', 'cursos', 'capacidad', 'alumnos', 'request', 'docente', 'trimestre', 'alumnosNotas', 'capacidad', 'alumnosPorCapacidad'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // Controlador
    public function ver(Request $request)
    {

        $idperiodo = session('periodoSeleccionado');


        

        $buscarpor = $request->get('buscarpor');
    
        $notas = Nota::with(['periodo', 'curso', 'grado', 'seccion', 'trimestre'])
        ->where('idperiodo', $idperiodo) // Filter by session period
        ->whereHas('curso', function ($query) use ($buscarpor) {
            $query->where('curso', 'like', '%' . $buscarpor . '%');
        })
        ->orderBy('idperiodo')
        ->orderBy('idCurso')
        ->orderBy('idGrado')
        ->orderBy('idSeccion')
        ->orderBy('idtrimestre')
        ->get();
    
        // Agrupa las notas por periodo, curso, grado y sección
        $gruposDeNotas = $notas->groupBy(function($item) {
            return $item->periodo->idperiodo . '-' . $item->curso->idCurso . '-' . $item->grado->idGrado . '-' . $item->seccion->idSeccion . '-' . $item->trimestre->idtrimestre;
        });
    
        return view('notas.ver', compact('gruposDeNotas', 'buscarpor'));
    }
    

    
    


    public function edit($idNotaTrimestre)
    {
        $notas = Nota::all();
    
        // También puedes cargar información adicional si es necesario
    
        return view('notas.edit', compact('notas'));
    }


    public function verAlumnosPorFiltros($periodo, $curso, $grado, $seccion, $trimestre)
{
    // Obtén el valor del campo de búsqueda
    $nombreApellido = request('nombreApellido');

    // Obtén las capacidades para el curso específico
    $capacidad = Capacidad::where('idCurso', '=', $curso)->get();

    // Obtén los datos de los alumnos y sus notas, cargando las relaciones necesarias
    $alumnosNotas = Nota::where('idperiodo', $periodo)
        ->where('idCurso', $curso)
        ->where('idGrado', $grado)
        ->where('idSeccion', $seccion)
        ->where('idTrimestre', $trimestre)
        ->whereHas('alumno', function ($query) use ($nombreApellido) {
            $query->where('nombres', 'like', '%' . $nombreApellido . '%')
                ->orWhere('apellidos', 'like', '%' . $nombreApellido . '%');
        })
        ->with(['curso', 'grado', 'seccion', 'docente', 'trimestre', 'capacidad']) // Cargar relación capacidad
        ->get();

    // Organiza los datos por alumno y capacidad
    $alumnosPorCapacidad = [];
    foreach ($alumnosNotas as $nota) {
        $alumnoId = $nota->dniAlumno;
        $capacidadId = $nota->idcapacidad;
        $notaValor = $nota->nota;

        if (!isset($alumnosPorCapacidad[$alumnoId])) {
            $alumnosPorCapacidad[$alumnoId] = [];
        }

        if (!isset($alumnosPorCapacidad[$alumnoId][$capacidadId])) {
            $alumnosPorCapacidad[$alumnoId][$capacidadId] = $notaValor;
        }
    }

    return view('notas.verAlumnos', compact('alumnosNotas', 'nombreApellido', 'capacidad', 'alumnosPorCapacidad'));
}

private function convertirNota($nota) {
    $valoresNotas = ['AD' => 4, 'A' => 3, 'B' => 2, 'C' => 1];
    return $valoresNotas[$nota];
}


private function convertirPromedioLetra($promedioNumerico) {
    if ($promedioNumerico == 4) {
        return "AD";
    } elseif ($promedioNumerico == 3) {
        return "A";
    } elseif ($promedioNumerico == 2) {
        return "B";
    } elseif ($promedioNumerico == 1) {
        return "C";
    } else {
        return ""; // Aquí puedes manejar otros casos si es necesario
    }
}

public function pdfPorCurso($periodo, $curso, $grado, $seccion, $trimestre){

    $capacidad = Capacidad::where('idCurso', '=', $curso)->get();

    $alumnosNotas = Nota::where('idperiodo', $periodo)
        ->where('idCurso', $curso)
        ->where('idGrado', $grado)
        ->where('idSeccion', $seccion)
        ->where('idtrimestre', $trimestre)
        ->with(['curso', 'grado', 'seccion', 'docente', 'trimestre', 'capacidad'])
        ->get();

    $alumnosPorCapacidad = [];
    foreach ($alumnosNotas as $nota) {
        $alumnoId = $nota->dniAlumno;
        $capacidadId = $nota->idcapacidad;
        $notaValor = $nota->nota;

        if (!isset($alumnosPorCapacidad[$alumnoId])) {
            $alumnosPorCapacidad[$alumnoId] = [];
        }

        if (!isset($alumnosPorCapacidad[$alumnoId][$capacidadId])) {
            $alumnosPorCapacidad[$alumnoId][$capacidadId] = $notaValor;
        }
    }
    $promedioAlumno = [];
        foreach ($alumnosPorCapacidad as $alumnoId => $notasPorCapacidad) {
            $sumaNotas = 0;
            $cantidadNotas = 0;
            
            foreach ($notasPorCapacidad as $nota) {
                $valorNota = $this->convertirNota($nota);
                $sumaNotas += $valorNota;
                $cantidadNotas++;
            }

            $promedioNumerico = $cantidadNotas > 0 ? round($sumaNotas / $cantidadNotas) : 0;
            $promedioLetra = $this->convertirPromedioLetra($promedioNumerico);

            $promedioAlumno[$alumnoId] = $promedioLetra;
        }


    $data = [
        'alumnosNotas' => $alumnosNotas,
        'capacidad' => $capacidad,
        'alumnosPorCapacidad' => $alumnosPorCapacidad,
        'promedioAlumno' => $promedioAlumno, // Agregar el array de promedios
    ];

    $pdf = PDF::loadView('notas.notasPdfPorCurso', $data);

    return $pdf->stream('Notasddds.pdf');
}



public function informetrimestre(Request $request){

    $periodo = $request->idperiodo;
    $curso = $request->idCurso;
    $grado = $request->idGrado;
    $seccion = $request->idSeccion;
    $trimestre = $request->idtrimestre;

    $capacidad = Capacidad::where('idCurso', '=', $curso)->get();

    $alumnosNotas = Nota::where('idperiodo', $periodo)
        ->where('idCurso', $curso)
        ->where('idGrado', $grado)
        ->where('idSeccion', $seccion)
        ->where('idtrimestre', $trimestre)
        ->with(['curso', 'grado', 'seccion', 'docente', 'trimestre', 'capacidad'])
        ->get();

    $alumnosPorCapacidad = [];
    foreach ($alumnosNotas as $nota) {
        $alumnoId = $nota->dniAlumno;
        $capacidadId = $nota->idcapacidad;
        $notaValor = $nota->nota;

        if (!isset($alumnosPorCapacidad[$alumnoId])) {
            $alumnosPorCapacidad[$alumnoId] = [];
        }

        if (!isset($alumnosPorCapacidad[$alumnoId][$capacidadId])) {
            $alumnosPorCapacidad[$alumnoId][$capacidadId] = $notaValor;
        }
    }
    $promedioAlumno = [];
        foreach ($alumnosPorCapacidad as $alumnoId => $notasPorCapacidad) {
            $sumaNotas = 0;
            $cantidadNotas = 0;
            
            foreach ($notasPorCapacidad as $nota) {
                $valorNota = $this->convertirNota($nota);
                $sumaNotas += $valorNota;
                $cantidadNotas++;
            }

            $promedioNumerico = $cantidadNotas > 0 ? round($sumaNotas / $cantidadNotas) : 0;
            $promedioLetra = $this->convertirPromedioLetra($promedioNumerico);

            $promedioAlumno[$alumnoId] = $promedioLetra;
        }


    $data = [
        'alumnosNotas' => $alumnosNotas,
        'capacidad' => $capacidad,
        'alumnosPorCapacidad' => $alumnosPorCapacidad,
        'promedioAlumno' => $promedioAlumno, // Agregar el array de promedios
    ];

    $pdf = PDF::loadView('notas.informetrimestre', $data);

    return $pdf->stream('NotasPorTrimestre.pdf');
}


public function calcularPromedioFinal($datosTrimestres)
{
    // Mapeo de notas a valores numéricos
    $mapeoNotas = [
        'AD' => 4,
        'A' => 3,
        'B' => 2,
        'C' => 1,
        // Agrega más letras y valores correspondientes si es necesario
    ];

    $promediosFinales = [];

    foreach ($datosTrimestres[0]['alumnosNotas'] as $alumno) {
        $promedioFinal = 0; // Inicializa el promedio final para este estudiante

        foreach ($datosTrimestres as $datosTrimestre) {
            $promedioAlumno = 0; // Inicializa el promedio del alumno en este trimestre
            $notasEstudiante = $datosTrimestre['alumnosPorCapacidad'][$alumno->dniAlumno] ?? null;

            if ($notasEstudiante) {
                $cantidadNotas = 0; // Inicializa la cantidad de notas válidas para el alumno

                foreach ($datosTrimestre['capacidad'] as $capacidad) {
                    $nota = $notasEstudiante[$capacidad->idcapacidad] ?? null;

                    if (isset($mapeoNotas[$nota])) {
                        $promedioAlumno += $mapeoNotas[$nota];
                        $cantidadNotas++; // Incrementa la cantidad de notas válidas
                    }
                }

                // Calcula el promedio del alumno para este trimestre
                if ($cantidadNotas > 0) {
                    $promedioAlumno /= $cantidadNotas;
                    $promedioFinal += $promedioAlumno; // Acumula el promedio del trimestre
                }
            }
        }

        // Calcula el promedio final en número
        $promedioFinalNumerico = $promedioFinal / count($datosTrimestres);

        // Convierte el promedio final a letra
        $promedioFinalLetra = $this->convertirPromedioLetra(round($promedioFinalNumerico));

        $promediosFinales[$alumno->dniAlumno] = $promedioFinalLetra;
    }

    return $promediosFinales;
}







public function generarInformePDF(Request $request) {
    $periodo = $request->idperiodo;
    $curso = $request->idCurso;
    $grado = $request->idGrado;
    $seccion = $request->idSeccion;
    $trimestres = Trimestre::where('idperiodo', $periodo)->get();

    $datosTrimestres = [];

    foreach ($trimestres as $trimestre) {
        $alumnosNotas = Nota::where('idperiodo', $periodo)
            ->where('idCurso', $curso)
            ->where('idGrado', $grado)
            ->where('idSeccion', $seccion)
            ->where('idtrimestre', $trimestre->idtrimestre)
            ->with(['curso', 'grado', 'seccion', 'docente', 'trimestre', 'capacidad'])
            ->get();

        $alumnosPorCapacidad = [];
        foreach ($alumnosNotas as $nota) {
            $alumnoId = $nota->dniAlumno;
            $capacidadId = $nota->idcapacidad;
            $notaValor = $nota->nota;

            if (!isset($alumnosPorCapacidad[$alumnoId])) {
                $alumnosPorCapacidad[$alumnoId] = [];
            }

            if (!isset($alumnosPorCapacidad[$alumnoId][$capacidadId])) {
                $alumnosPorCapacidad[$alumnoId][$capacidadId] = $notaValor;
            }
        }

        $promedioAlumno = [];
        foreach ($alumnosPorCapacidad as $alumnoId => $notasPorCapacidad) {
            $sumaNotas = 0;
            $cantidadNotas = 0;

            foreach ($notasPorCapacidad as $nota) {
                $valorNota = $this->convertirNota($nota);
                $sumaNotas += $valorNota;
                $cantidadNotas++;
            }

            $promedioNumerico = $cantidadNotas > 0 ? round($sumaNotas / $cantidadNotas) : 0;
            $promedioLetra = $this->convertirPromedioLetra($promedioNumerico);

            $promedioAlumno[$alumnoId] = $promedioLetra;
        }

        $datosTrimestres[] = [
            'trimestre' => $trimestre,
            'alumnosNotas' => $alumnosNotas,
            'capacidad' => Capacidad::where('idCurso', '=', $curso)->get(),
            'alumnosPorCapacidad' => $alumnosPorCapacidad,
            'promedioAlumno' => $promedioAlumno,
        ];
    }

    // Calcular el promedio final
    $promediosFinales = $this->calcularPromedioFinal($datosTrimestres);

    $data = [
        'datosTrimestres' => $datosTrimestres,
        'promediosFinales' => $promediosFinales,
    ];
    $pdf = PDF::loadView('notas.informepdf', $data)->setPaper([0, 0, 792, 1500], 'landscape');
    
    return $pdf->stream('NotasTrimestres.pdf');
}









    public function store(Request $request)
{
    $data = request()->validate([
        'idcapacidad' => 'required'
    ],
    [
        'idcapacidad' => 'Seleccione una capacidad'
    ]);

    $alumnos = Matricula::where('idperiodo', '=', $request->idperiodo)
        ->where('idGrado', '=', $request->idGrado)
        ->where('idSeccion', '=', $request->idSeccion)
        ->get();
    $trimestre = Trimestre::all();

    $nivelEscolar = Nivel::all();
    $periodo = Periodo::all();
    $grado = Grado::where('idNivel', '=', $request->idNivel)->get();
    $seccion = Seccion::where('estado', '=', '1')->where('idGrado', '=', $request->idGrado)->get();
    $cursos = Curso::where('estado', '=', '1')->where('idNivel', '=', $request->idNivel)->get();
    $capacidad = Capacidad::where('idCurso', '=', $request->idCurso)->get();
    $docente = Docente_Curso::where('estado', '=', '1')
        ->where('idperiodo', '=', $request->idperiodo)
        ->where('idCurso', '=', $request->idCurso)
        ->where('idGrado', '=', $request->idGrado)
        ->where('idSeccion', '=', $request->idSeccion)
        ->first();

    if ($docente === null) {
        $docente = null;
    }

    $notas = Nota::where('idperiodo', '=', $request->idperiodo)
        ->where('idcapacidad', '=', $request->idcapacidad)
        ->where('idGrado', '=', $request->idGrado)
        ->where('idSeccion', '=', $request->idSeccion)
        ->where('idtrimestre', '=', $request->idtrimestre)
        ->get();

    return view('notas.index', compact('nivelEscolar', 'periodo', 'grado', 'seccion', 'cursos', 'capacidad', 'alumnos', 'request', 'docente', 'trimestre'));
}


public function guardarNotas(Request $request) {
    // Obtiene los datos JSON enviados desde JavaScript
    $data = $request->json()->all();

    // Puedes acceder a los campos como $data['idperiodo'], $data['idGrado'], etc.
    
    // Para acceder a la lista de alumnos y sus capacidades:
    $alumnos = $data['alumnos'];

    foreach ($alumnos as $alumno) {
        $dniAlumno = $alumno['dni'];
        $capacidades = $alumno['capacidades'];

        foreach ($capacidades as $capacidad) {
            $idCapacidad = $capacidad['idCapacidad'];
            $nota = $capacidad['nota'];

            // Crea una nueva instancia de la clase Nota y asigna los valores
            $nuevaNota = new Nota();
            $nuevaNota->dniAlumno = $dniAlumno;
            $nuevaNota->idcapacidad = $idCapacidad;
            $nuevaNota->nota = $nota;

            // Asigna otros campos si es necesario
            $nuevaNota->idperiodo = $data['idperiodo'];
            $nuevaNota->idGrado = $data['idGrado'];
            $nuevaNota->idSeccion = $data['idSeccion'];
            $nuevaNota->idCurso = $data['idCurso'];
            $nuevaNota->idtrimestre = $data['idtrimestre'];
            $nuevaNota->codDocente = $data['codDocente'];

            // Guarda la nueva nota en la base de datos
            $nuevaNota->save();
        }
    }

    // Puedes redirigir a la página anterior o a donde sea necesario
    return response()->json(['message' => 'Notas guardadas con éxito', 'redirect' => 'ver']);
}



public function actualizarNotas(Request $request)
{
    // \DB::enableQueryLog();
    $data = $request->json()->all();

    // Obtén la lista de alumnos y sus capacidades
    $alumnos = $data['alumnos'];

    foreach ($alumnos as $alumno) {
        $dniAlumno = $alumno['dni'];
        $capacidades = $alumno['capacidades'];

        foreach ($capacidades as $capacidad) {
            $idCapacidad = $capacidad['idCapacidad'];
            $nota = $capacidad['nota'];

            // Encuentra la nota existente en la base de datos por criterios incluyendo 'idnotaTrimestre'
            $notaExistente = Nota::where('dniAlumno', $dniAlumno)
                ->where('idcapacidad', $idCapacidad)
                ->where('idtrimestre', $data['idtrimestre'])
                ->where('codDocente', $data['codDocente'])
                ->where('idperiodo', $data['idperiodo'])
                ->where('idGrado', $data['idGrado'])
                ->where('idSeccion', $data['idSeccion'])
                ->where('idCurso', $data['idCurso'])
                ->first();

            if ($notaExistente) {
                // Actualiza la nota existente con el nuevo valor
                $notaExistente->nota = $nota;
                $notaExistente->save();
            } 
        }
    }
    // \Log::info(\DB::getQueryLog());
    // Devuelve una respuesta de éxito
    return response()->json(['message' => 'Notas actualizadas con éxito']);
}

    public function eliminar($idperiodo, $idCurso, $idGrado, $idSeccion, $idtrimestre) {

        Nota::where('idperiodo', $idperiodo)
            ->where('idCurso', $idCurso)
            ->where('idGrado', $idGrado)
            ->where('idSeccion', $idSeccion)
            ->where('idtrimestre', $idtrimestre)
            ->delete();

        return redirect()->back()->with('datos', 'Registros eliminados con éxito.');
    }


    public function boletaDeNotas(Request $request)
    {
        $alumnos = null;
        $trimestre = Trimestre::where('estado','=','1')->get();

        $periodo = Periodo::all();
        $nivelEscolar = Nivel::all();
        $grado = Grado::all();
        $seccion = Seccion::where('estado', '=', '1')->get();

        if($request !== null)
        {
            if($request->idNivel == null)
            {
                $alumnos = Matricula::where('idperiodo','=',$request->idperiodo)->where('estado','=','1')->paginate($this::PAGINATION);
            }
            else
            {
                if($request->idGrado == null)
                {
                    if($request->idNivel == '1')
                    {
                        $grados = [1, 2, 3]; 
                        $alumnos = Matricula::where('idperiodo', '=', $request->idperiodo)
                            ->whereIn('idGrado', $grados)
                            ->where('estado', '=', '1')
                            ->paginate($this::PAGINATION);
                    }
                    if($request->idNivel == '2')
                    {
                        $grados = [4, 5, 6, 7, 8, 9]; 
                        $alumnos = Matricula::where('idperiodo', '=', $request->idperiodo)
                            ->whereIn('idGrado', $grados)
                            ->where('estado', '=', '1')
                            ->paginate($this::PAGINATION);
                    }
                    if($request->idNivel == '3')
                    {
                        $grados = [10, 11, 12, 13, 14,]; 
                        $alumnos = Matricula::where('idperiodo', '=', $request->idperiodo)
                            ->whereIn('idGrado', $grados)
                            ->where('estado', '=', '1')
                            ->paginate($this::PAGINATION);
                    }
                }
                else
                {
                    if($request->idSeccion == null)
                    {
                        $alumnos = Matricula::where('idperiodo','=',$request->idperiodo)->where('idGrado','=',$request->idGrado)->where('estado','=','1')->paginate($this::PAGINATION);
                    }
                    else
                    {
                        $alumnos = Matricula::where('idperiodo','=',$request->idperiodo)->where('idGrado','=',$request->idGrado)->where('idSeccion','=',$request->idSeccion)->where('estado','=','1')->paginate($this::PAGINATION);
                    }
                }
            }
        }

        return view('notas.boleta', compact('alumnos','periodo','request', 'nivelEscolar', 'grado', 'seccion', 'trimestre'));
    }

    public function boletaTrimestre($dniAlumno, Request $request)
{
    $periodo = $request->idperiodo;
    $grado = $request->idGrado;
    $seccion = $request->idSeccion;
    $trimestre = $request->idtrimestre;
    $alumno = Alumno::where('dniAlumno', $dniAlumno)->first();

    $notas = Nota::where('idperiodo', $periodo)
        ->where('idGrado', $grado)
        ->where('idSeccion', $seccion)
        ->where('idtrimestre', $trimestre)
        ->where('dniAlumno', $dniAlumno)
        ->get();

    if ($notas->isEmpty()) {
        // Aquí puedes manejar el caso en el que no hay notas disponibles
    }

    $capacidad = Capacidad::where('idCurso', '=', $notas->first()->idCurso)->get();

    $promedios = [];
    foreach ($notas->groupBy('idCurso') as $cursoId => $notasPorCurso) {
        $promedioNumerico = 0;
        foreach ($notasPorCurso as $nota) {
            $promedioNumerico += $this->convertirNota($nota->nota);
        }
        $promedioNumerico = $promedioNumerico / count($notasPorCurso);
        $promedioLetra = $this->convertirPromedioLetra(round($promedioNumerico));

        $promedios[$cursoId] = $promedioLetra;
    }

    $pdf = PDF::loadView('notas.boletaTrimestre', compact('notas', 'trimestre', 'alumno', 'capacidad', 'promedios'));

    return $pdf->stream();
}

public function boletaAnual($dniAlumno, Request $request)
{
    $periodo = $request->input('idperiodo');
    $grado = $request->input('idGrado');
    $seccion = $request->input('idSeccion');
    $alumno = Alumno::where('dniAlumno', $dniAlumno)->first();
    $trimestres = Trimestre::where('idperiodo', $periodo)->get();
    
    $notasPorTrimestre = [];
    $promediosAnuales = [];

    foreach ($trimestres as $trimestre) {
        $notas = Nota::where('idperiodo', $periodo)
            ->where('idGrado', $grado)
            ->where('idSeccion', $seccion)
            ->where('dniAlumno', $dniAlumno)
            ->where('idTrimestre', $trimestre->idtrimestre)
            ->get();

        $capacidad = Capacidad::where('idCurso', '=', $notas->first()->idCurso)->get();

        $promedios = [];
        foreach ($notas->groupBy('idCurso') as $cursoId => $notasPorCurso) {
            $promedioNumerico = 0;
            foreach ($notasPorCurso as $nota) {
                $promedioNumerico += $this->convertirNota($nota->nota);
            }
            $promedioNumerico = $promedioNumerico / count($notasPorCurso);
            $promedioLetra = $this->convertirPromedioLetra(round($promedioNumerico));

            $promedios[$cursoId] = $promedioLetra;
        }

        $notasPorTrimestre[] = [
            'trimestre' => $trimestre,
            'notas' => $notas,
            'capacidad' => $capacidad,
            'promedios' => $promedios,
        ];

        // Calcular promedios anuales aquí
        foreach ($promedios as $cursoId => $promedio) {
            if (!isset($promediosAnuales[$cursoId])) {
                $promediosAnuales[$cursoId] = 0;
            }
            $promediosAnuales[$cursoId] += $this->convertirNota($promedio);
        }
    }

    // Calcular promedios anuales finales aquí
    $promedioFinal = [];
    foreach ($promediosAnuales as $cursoId => $promedioAnual) {
        $promedioFinal[$cursoId] = $this->convertirPromedioLetra(round($promedioAnual / count($trimestres)));
    }

    $pdf = PDF::loadView('notas.boletaAnual', compact('notasPorTrimestre', 'alumno', 'promedioFinal'));

    return $pdf->stream();
}








    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
