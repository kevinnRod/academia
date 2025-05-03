<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examen;
use App\Models\Tipo_Examen;
use App\Models\Periodo;
use App\Models\Tipo_Ciclo;
use App\Models\Area;
use App\Models\Ciclo;
use App\Models\Aula;
use App\Models\NotaExamen;
use App\Models\Matricula;
use App\Models\Alumno;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;


class NotaExamenController extends Controller
{
    public function index(Request $request)
    {
        

        // Obtener los filtros de la solicitud
        $buscarpor = $request->get('buscarpor');
        $idperiodo = $request->get('idperiodo');
        $idtipociclo = $request->get('idtipociclo');
        $idarea = $request->get('idarea');
        $idciclo = $request->get('idciclo');
        $idtipoexamen = $request->get('idtipoexamen');
        $idaula = $request->get('idaula');
        // Construir la consulta con los filtros aplicados
        $query = Examen::query();

        if ($buscarpor) {
            $query->where('descripcion', 'like', '%' . $buscarpor . '%');
        }

        if ($idperiodo) {
            $query->whereHas('aula.ciclo', function ($q) use ($idperiodo) {
                $q->where('idperiodo', $idperiodo);
            });
        }

        if ($idtipociclo) {
            $query->whereHas('aula.ciclo.tipo_ciclo', function ($q) use ($idtipociclo) {
                $q->where('idtipociclo', $idtipociclo);
            });
        }

        if ($idarea) {
            $query->whereHas('aula.ciclo.area', function ($q) use ($idarea) {
                $q->where('idarea', $idarea);
            });
        }

        if ($idciclo) {
            $query->whereHas('aula', function ($q) use ($idciclo) {
                $q->where('idciclo', $idciclo);
            });
        }

        if ($idtipoexamen) {
            $query->where('idtipoexamen', $idtipoexamen);
        }

        if ($idaula) {
            $query->where('idaula', $idaula);
        }

        $examenes = $query->paginate(10);

        $periodos = Periodo::all()->where('estado', '=', 1);;
        $tiposCiclo = Tipo_Ciclo::all();
        $areas = Area::all();
        $aulas = Aula::all();
        $ciclos = Ciclo::all();
        $tiposExamen = Tipo_Examen::all();
        $idperiodoSeleccionado = session('periodoSeleccionado');

        


        return view('notaExamen.index', compact('examenes', 'periodos', 'tiposCiclo', 'areas', 'ciclos', 'tiposExamen', 'idperiodoSeleccionado', 'aulas'));
    }



    public function create()
    {
        $periodos = Periodo::all();
        $tiposExamen = Tipo_Examen::all();
        $tiposCiclo = Tipo_Ciclo::all();
        $areas = Area::all();
        $ciclos = Ciclo::all();
        $aulas = Aula::all();

        $idperiodoSeleccionado = session('periodoSeleccionado');
        return view('notaExamen.create', compact('periodos', 'tiposExamen', 'tiposCiclo', 'areas', 'ciclos', 'idperiodoSeleccionado', 'aulas'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'descripcion' => 'required|string|max:255',
    //         'fecha' => 'required|date',
    //         'idaula' => 'required|exists:aula,idaula',
    //         'idtipoexamen' => 'required|exists:tipo_examen,idtipoexamen',
    //         'estado' => 'required|boolean'
    //     ]);

    //     Examen::create($request->all());
    //     return redirect()->route('examen.index');
    // }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'idexamen' => 'required|exists:examen,idexamen',
            'buenasconocimiento.*' => 'numeric|min:0',
            'malasconocimiento.*' => 'numeric|min:0',
            'buenasaptitud.*' => 'numeric|min:0',
            'malasaptitud.*' => 'numeric|min:0',
        ]);
    
        $idexamen = $request->input('idexamen');
    
        // Iniciar una transacción para asegurar la atomicidad
        DB::beginTransaction();
    
        try {
            // Obtener todas las matrículas del request
            $numMatriculas = array_keys($request->input('buenasconocimiento', []));
    
            foreach ($numMatriculas as $numMatricula) {
                // Obtener las respuestas buenas y malas
                $buenasConocimiento = $request->input("buenasconocimiento.$numMatricula");
                $malasConocimiento = $request->input("malasconocimiento.$numMatricula");
                $buenasAptitud = $request->input("buenasaptitud.$numMatricula");
                $malasAptitud = $request->input("malasaptitud.$numMatricula");
    
                // Calcular las notas
                $notaConocimientos = ($buenasConocimiento * 4.079) + ($malasConocimiento * -1.021);
                $notaAptitud = ($buenasAptitud * 4.079) + ($malasAptitud * -1.021);
                $notaTotal = $notaConocimientos + $notaAptitud;
    
                // Encontrar o crear una entrada en NotaExamen
                $notaExamen = NotaExamen::where('idexamen', $idexamen)
                    ->where('numMatricula', $numMatricula)
                    ->first();
    
                if ($notaExamen) {
                    // Actualizar la nota existente
                    $notaExamen->update([
                        'buenasconocimiento' => $buenasConocimiento,
                        'malasconocimiento' => $malasConocimiento,
                        'buenasaptitud' => $buenasAptitud,
                        'malasaptitud' => $malasAptitud,
                        'notaconocimientos' => $notaConocimientos,
                        'notaaptitud' => $notaAptitud,
                        'notatotal' => $notaTotal,
                    ]);
                } else {
                    // Crear una nueva nota
                    NotaExamen::create([
                        'idexamen' => $idexamen,
                        'numMatricula' => $numMatricula,
                        'buenasconocimiento' => $buenasConocimiento,
                        'malasconocimiento' => $malasConocimiento,
                        'buenasaptitud' => $buenasAptitud,
                        'malasaptitud' => $malasAptitud,
                        'notaconocimientos' => $notaConocimientos,
                        'notaaptitud' => $notaAptitud,
                        'notatotal' => $notaTotal,
                    ]);
                }
            }
    
            // Confirmar la transacción
            DB::commit();
    
            return redirect()->route('notaExamen.index')->with('message', 'Notas guardadas exitosamente.');
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Error al guardar las notas. Inténtelo de nuevo.']);
        }
    }
    


    public function edit($id)
    {
        // Cargar el examen con las relaciones necesarias
        $examen = Examen::with(['aula.ciclo.periodo', 'aula.ciclo.tipo_ciclo', 'aula.ciclo.area'])->find($id);
        
        // Recuperar las matrículas asociadas al aula del examen
        $matriculas = Matricula::where('idaula', $examen->idaula)
            ->join('alumnos', 'alumnos.dniAlumno', '=', 'matriculas.dniAlumno')
            ->orderBy('alumnos.apellidos', 'asc') 
            ->orderBy('alumnos.nombres', 'asc') 
            ->get(); 

        // Recuperar las notas existentes para el examen
        $notas = NotaExamen::where('idexamen', $id)->get()->keyBy('numMatricula');

        // Pasar los datos a la vista
        return view('notaExamen.edit', compact('examen', 'matriculas', 'notas'));
    }


    // public function edit($id)
    // {
    //     $examen = Examen::with(['aula.ciclo.periodo', 'aula.ciclo.tipo_ciclo', 'aula.ciclo.area'])->find($id);
    //     $matriculas = Matricula::where('idexamen', $id)->get(); // Recupera todas las matrículas para el examen dado

    //     // Cargar notas relacionadas con el examen
    //     $notas = NotaExamen::where('idexamen', $id)->get()->keyBy('numMatricula');

    //     return view('notaExamen.edit', compact('examen', 'matriculas', 'notas'));
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fecha' => 'required|date',
            'idaula' => 'required|exists:aula,idaula',
            'idtipoexamen' => 'required|exists:tipo_examen,idtipoexamen',
            'estado' => 'required|boolean'
        ]);

        $examen = Examen::findOrFail($id);
        $examen->update($request->all());
        return redirect()->route('notaExamen.index');
    }

    public function destroy($id)
    {
        // $examen = Examen::findOrFail($id);
        // $examen->delete();
        // return redirect()->route('notaExamen.index');

        // Eliminar todas las notas asociadas con el examen
        NotaExamen::where('idexamen', $id)->delete();

        // Redireccionar con un mensaje de éxito
        return redirect()->route('notaExamen.index')->with('success', 'Notas eliminadas correctamente.');
    }
    // public function eliminarNotas($idexamen)
    // {
        
    // }
    public function confirmar($id)
    {
        $examen = Examen::findOrFail($id);
        return view('notaExamen.confirmar', compact('examen'));
    }



    public function imprimir($idexamen)
    {
        $examen = Examen::findOrFail($idexamen);
        $notas = NotaExamen::where('idexamen', $idexamen)
                           ->orderBy('notatotal', 'desc')
                           ->get();
    
        $pdf = Pdf::loadView('notaExamen.pdf', compact('examen', 'notas'));

        $startTime = session('start_report_time');
        if ($startTime) {
            $startTime = new \DateTime($startTime);
            $endTime = new \DateTime();
            $interval = $startTime->diff($endTime);
            $duration = $interval->format('%H:%I:%S');

            // Guardar la duración en el archivo CSV
            $this->saveDurationToCsvPDF($startTime->format('Y-m-d H:i:s'), $endTime->format('Y-m-d H:i:s'), $duration);

            // Limpiar el tiempo de inicio de la sesión
            session()->forget('start_report_time');
        }
    
        return $pdf->stream('notas_examen_' . $examen->idexamen . '.pdf');
    }
    
    private function saveDurationToCsvPDF($startTime, $endTime, $duration)
    {
        $filePath = public_path('images/reportePDFAula.csv'); // Ruta correcta para la carpeta pública
    
        // Crear la carpeta si no existe
        $directory = public_path('images');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    
        // Abre el archivo en modo de adición
        $file = fopen($filePath, 'a');
    
        // Si el archivo está vacío, escribe la cabecera
        if (filesize($filePath) === 0) {
            fputcsv($file, ['Tiempo inicial', 'Tiempo final', 'Duración']);
        }
    
        // Escribe la fila de datos
        fputcsv($file, [$startTime, $endTime, $duration]);
    
        // Cierra el archivo
        fclose($file);
    }



    public function generarPdfSinFormato($idexamen)
    {
        $examen = Examen::findOrFail($idexamen);
        $notas = NotaExamen::where('idexamen', $idexamen)
                           ->orderBy('notatotal', 'desc')
                           ->get();

        $pdf = PDF::loadView('notaExamen.sin_formato', compact('examen', 'notas'));

        // Retorna el PDF en una nueva ventana
        return $pdf->stream('Notas_Examen_Sin_Formato.pdf');
    }

    public function generarGraficoCircular($idexamen)
    {
    $examen = Examen::findOrFail($idexamen);
    $notas = NotaExamen::where('idexamen', $idexamen)
    ->orderBy('notatotal', 'desc')
    ->get();


    // Contar alumnos en cada rango de notas
    $rangoNotas = [
        '0-50' => 0,
        '51-100' => 0,
        '101-150' => 0,
        '151-200' => 0,
        '201-250' => 0,
        '251-300' => 0,
        '301+' => 0,
    ];

    foreach ($notas as $nota) {
        if ($nota->notatotal <= 50) {
            $rangoNotas['0-50']++;
        } elseif ($nota->notatotal <= 100) {
            $rangoNotas['51-100']++;
        } elseif ($nota->notatotal <= 150) {
            $rangoNotas['101-150']++;
        } elseif ($nota->notatotal <= 200) {
            $rangoNotas['151-200']++;
        } elseif ($nota->notatotal <= 250) {
            $rangoNotas['201-250']++;
        } elseif ($nota->notatotal <= 300) {
            $rangoNotas['251-300']++;
        } else {
            $rangoNotas['301+']++;
        }
    }

    return view('notaExamen.circular', compact('examen', 'rangoNotas'));
}
public function reportes(Request $request)
{
    // Registrar el tiempo de inicio solo si no está registrado en la sesión
    if (!$request->session()->has('start_report_time')) {
        $request->session()->put('start_report_time', now()->toDateTimeString());
    }

    // Aquí va el código para manejar la búsqueda y filtros
    return $this->handleFilters($request);
}

public function handleFilters(Request $request)
{
    // Obtener los filtros de la solicitud
    $buscarpor = $request->get('buscarpor');
    $idperiodo = $request->get('idperiodo');
    $idtipociclo = $request->get('idtipociclo');
    $idarea = $request->get('idarea');
    $idciclo = $request->get('idciclo');
    $idtipoexamen = $request->get('idtipoexamen');
    $idaula = $request->get('idaula');

    // Construir la consulta con los filtros aplicados
    $query = Examen::query();

    if ($buscarpor) {
        $query->where('descripcion', 'like', '%' . $buscarpor . '%');
    }

    if ($idperiodo) {
        $query->whereHas('aula.ciclo', function ($q) use ($idperiodo) {
            $q->where('idperiodo', $idperiodo);
        });
    }

    if ($idtipociclo) {
        $query->whereHas('aula.ciclo.tipo_ciclo', function ($q) use ($idtipociclo) {
            $q->where('idtipociclo', $idtipociclo);
        });
    }

    if ($idarea) {
        $query->whereHas('aula.ciclo.area', function ($q) use ($idarea) {
            $q->where('idarea', $idarea);
        });
    }

    if ($idciclo) {
        $query->whereHas('aula', function ($q) use ($idciclo) {
            $q->where('idciclo', $idciclo);
        });
    }

    if ($idtipoexamen) {
        $query->where('idtipoexamen', $idtipoexamen);
    }

    if ($idaula) {
        $query->where('idaula', $idaula);
    }

    $examenes = $query->paginate(10);

    $periodos = Periodo::all()->where('estado', '=', 1);
    $tiposCiclo = Tipo_Ciclo::all();
    $areas = Area::all();
    $aulas = Aula::all();
    $ciclos = Ciclo::all();
    $tiposExamen = Tipo_Examen::all();
    $idperiodoSeleccionado = session('periodoSeleccionado');

    return view('notaExamen.reportes', compact('examenes', 'periodos', 'tiposCiclo', 'areas', 'ciclos', 'tiposExamen', 'idperiodoSeleccionado', 'aulas'));
}

    public function generarDatosGraficoCircular($idexamen)
    {
        $examen = Examen::findOrFail($idexamen);
        $notas = NotaExamen::where('idexamen', $idexamen)
            ->orderBy('notatotal', 'desc')
            ->get();
    
        // Contar alumnos en cada rango de notas
        $rangoNotas = [
            '0-50' => 0,
            '51-100' => 0,
            '101-150' => 0,
            '151-200' => 0,
            '201-250' => 0,
            '251-300' => 0,
            '301+' => 0,
        ];
    
        $totalAlumnos = 0; // Variable para contar el total de alumnos
        
        foreach ($notas as $nota) {
            $totalAlumnos++; // Incrementar el contador total de alumnos
            
            if ($nota->notatotal <= 50) {
                $rangoNotas['0-50']++;
            } elseif ($nota->notatotal <= 100) {
                $rangoNotas['51-100']++;
            } elseif ($nota->notatotal <= 150) {
                $rangoNotas['101-150']++;
            } elseif ($nota->notatotal <= 200) {
                $rangoNotas['151-200']++;
            } elseif ($nota->notatotal <= 250) {
                $rangoNotas['201-250']++;
            } elseif ($nota->notatotal <= 300) {
                $rangoNotas['251-300']++;
            } else {
                $rangoNotas['301+']++;
            }
        }
    
        // Convertir el rango de notas en formato adecuado para el gráfico
        $data = [
            'labels' => array_keys($rangoNotas),
            'data' => array_values($rangoNotas),
            'totalAlumnos' => $totalAlumnos, // Devolver el total de alumnos
        ];

        $startTime = session('start_report_time');
        if ($startTime) {
            $startTime = new \DateTime($startTime);
            $endTime = new \DateTime();
            $interval = $startTime->diff($endTime);
            $duration = $interval->format('%H:%I:%S');

            // Guardar la duración en el archivo CSV
            $this->saveDurationToCsv($startTime->format('Y-m-d H:i:s'), $endTime->format('Y-m-d H:i:s'), $duration);

            // Limpiar el tiempo de inicio de la sesión
            session()->forget('start_report_time');
        }
    
        return response()->json($data);
    }

    private function saveDurationToCsv($startTime, $endTime, $duration)
    {
        $filePath = public_path('images/reportes.csv'); // Ruta correcta para la carpeta pública

        // Crear la carpeta si no existe
        $directory = public_path('images');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        // Abre el archivo en modo de adición
        $file = fopen($filePath, 'a');

        // Si el archivo está vacío, escribe la cabecera
        if (filesize($filePath) === 0) {
            fputcsv($file, ['Tiempo inicial', 'Tiempo final', 'Duración']);
        }

        // Escribe la fila de datos
        fputcsv($file, [$startTime, $endTime, $duration]);

        // Cierra el archivo
        fclose($file);
    }
    
    // public function notasAlumnos(Request $request)
    // {
    //     // Obtener el ID del aula desde la solicitud
    //     $idAula = $request->input('idaula');
    
    //     // Obtener los datos para los filtros
    //     $periodos = Periodo::all();
    //     $tiposCiclo = Tipo_Ciclo::all();
    //     $areas = Area::all();
    //     $ciclos = Ciclo::all();
    //     $tiposExamen = Tipo_Examen::all();
    //     $aulas = Aula::all();
    //     $idperiodoSeleccionado = session('periodoSeleccionado');

    //     // Construir la consulta para obtener las notas de los alumnos en el aula seleccionado
    //     $notas = NotaExamen::query()
    //         ->select('notaexamen.numMatricula', 'alumnos.nombres', 'alumnos.apellidos', 'notaexamen.notaaptitud', 'notaexamen.notaconocimientos', 'notaexamen.notatotal', 'alumnos.dniAlumno')
    //         ->join('matriculas', 'notaexamen.numMatricula', '=', 'matriculas.numMatricula') // Unir con la tabla Matricula
    //         ->join('alumnos', 'matriculas.dniAlumno', '=', 'alumnos.dniAlumno') // Unir con la tabla Alumno
    //         ->when($idAula, function ($query, $idAula) {
    //             return $query->where('matriculas.idaula', $idAula); // Filtrar por el ID del aula
    //         })
    //         ->get();
    
    //     // Pasar los datos necesarios a la vista
    //     return view('notaExamen.notasAlumno', [
    //         'notas' => $notas,
    //         'periodos' => $periodos,
    //         'tiposCiclo' => $tiposCiclo,
    //         'areas' => $areas,
    //         'ciclos' => $ciclos,
    //         'tiposExamen' => $tiposExamen,
    //         'aulas' => $aulas,
    //         'idAula' => $idAula,
    //         'idperiodoSeleccionado' => $idperiodoSeleccionado
    //     ]);
    // }

    public function notasAlumnos(Request $request)
    {
        // Registrar el tiempo de inicio solo si no está registrado en la sesión
        if (!$request->session()->has('start_notas_alumnos_time')) {
            $request->session()->put('start_notas_alumnos_time', now()->toDateTimeString());
        }

        // Aquí va el código para manejar la búsqueda y filtros
        return $this->notasAlumnos1($request);
    }

    public function notasAlumnos1(Request $request)
    {
        // Obtener los filtros de la solicitud
        $idperiodo = $request->input('idperiodo');
        $idtipociclo = $request->input('idtipociclo');
        $idarea = $request->input('idarea');
        $idciclo = $request->input('idciclo');
        $idtipoexamen = $request->input('idtipoexamen');
        $idaula = $request->input('idaula');
        $buscarpor = $request->input('buscarpor'); // Buscar por DNI, nombre o apellidos
        $idtipoexamen = $request->input('idtipoexamen');

        // Inicializar la consulta base
        $query = Alumno::select(
            'matriculas.numMatricula',
            'alumnos.dniAlumno',
            'alumnos.nombres',
            'alumnos.apellidos',
            'alumnos.fechaNacimiento',
            'alumnos.featured',
            'aula.descripcion as aula_descripcion',
            'ciclo.descripcion as ciclo_descripcion',
            'area.descripcion as area_descripcion',
            'tipo_ciclo.descripcion as tipo_ciclo_descripcion',
            'periodo.idperiodo',
            'aula.idaula',
            'carrera.descripcion as carrera_descripcion'
        )
        ->join('matriculas', 'alumnos.dniAlumno', '=', 'matriculas.dniAlumno')
        ->join('carrera', 'alumnos.idcarrera', '=','carrera.idcarrera')
        ->join('aula', 'matriculas.idaula', '=', 'aula.idaula')
        ->join('ciclo', 'aula.idciclo', '=', 'ciclo.idciclo')
        ->join('area', 'ciclo.idarea', '=', 'area.idarea')
        ->join('tipo_ciclo', 'ciclo.idtipociclo', '=', 'tipo_ciclo.idtipociclo')
        ->join('periodo', 'ciclo.idperiodo', '=', 'periodo.idperiodo')
        ->where('matriculas.estado', 1)
        ->distinct();
        
        // Agregar filtros condicionales
        if ($idperiodo) {
            $query->where('ciclo.idperiodo', $idperiodo);
        }
        
        if ($idtipociclo) {
            $query->where('ciclo.idtipociclo', $idtipociclo);
        }
        
        if ($idarea) {
            $query->where('ciclo.idarea', $idarea);
        }
        
        if ($idciclo) {
            $query->where('ciclo.idciclo', $idciclo);
        }
        
        if ($idaula) {
            $query->where('aula.idaula', $idaula);
        }
        
        if ($buscarpor) {
            $query->where(function ($q) use ($buscarpor) {
                $q->where('alumnos.dniAlumno', 'LIKE', "%$buscarpor%")
                  ->orWhere('alumnos.nombres', 'LIKE', "%$buscarpor%")
                  ->orWhere('alumnos.apellidos', 'LIKE', "%$buscarpor%");
            });
        }
        
        // Ejecutar la consulta
        $alumnos = $query->get();
        
        // Obtener datos para los filtros
        $periodos = Periodo::all()->where('estado', '=', 1);;
        $tiposCiclo = Tipo_Ciclo::all();
        $areas = Area::all();
        $ciclos = Ciclo::all();
        $aulas = Aula::all();
        $idperiodoSeleccionado = session('periodoSeleccionado');
        $tiposExamen = Tipo_Examen::all();
        return view('notaExamen.notasAlumno', [
            'alumnos' => $alumnos,
            'periodos' => $periodos,
            'tiposCiclo' => $tiposCiclo,
            'areas' => $areas,
            'ciclos' => $ciclos,
            'aulas' => $aulas,
            'idperiodoSeleccionado' => $idperiodoSeleccionado,
            'tiposExamen' => $tiposExamen
        ]);
    }
    

    
    // public function notasAlumnos(Request $request)
    // {
    //     // Obtener los filtros de la solicitud
    //     $idperiodo = $request->input('idperiodo');
    //     $idtipociclo = $request->input('idtipociclo');
    //     $idarea = $request->input('idarea');
    //     $idciclo = $request->input('idciclo');
    //     $idtipoexamen = $request->input('idtipoexamen');
    //     $idaula = $request->input('idaula');
    //     $buscarpor = $request->input('buscarpor'); // Nuevo campo para buscar por DNI
    
    //     // Inicializar la consulta base
    //     $query = Alumno::select(
    //         'matriculas.numMatricula',
    //         'matriculas.dniAlumno',
    //         'alumnos.nombres',
    //         'alumnos.apellidos',
    //         'alumnos.fechaNacimiento',
    //         'alumnos.featured',
    //         'carrera.descripcion as carrera_descripcion',
    //         'aula.descripcion as aula_descripcion'
    //     )
    //     ->join('matriculas', 'alumnos.dniAlumno', '=', 'matriculas.dniAlumno')
    //     ->join('carrera', 'alumnos.idcarrera', '=', 'carrera.idcarrera')
    //     ->join('aula as aula_matricula', 'matriculas.idaula', '=', 'aula_matricula.idaula')
    //     ->where('matriculas.estado', 1)
    //     ->distinct();
        
    //     // Agregar filtros condicionales
    //     if ($idaula) {
    //         $query->where('aula_matricula.idaula', $idaula);
    //     }
        
    //     if ($buscarpor) {
    //         $query->where(function ($q) use ($buscarpor) {
    //             $q->where('alumnos.dniAlumno', 'LIKE', "%$buscarpor%")
    //               ->orWhere('alumnos.nombres', 'LIKE', "%$buscarpor%")
    //               ->orWhere('alumnos.apellidos', 'LIKE', "%$buscarpor%");
    //         });
    //     }
        
    //     $alumnos = $query->distinct()->get();
        
    //     // Obtener datos para los filtros
    //     $periodos = Periodo::all();
    //     $tiposCiclo = Tipo_Ciclo::all();
    //     $areas = Area::all();
    //     $ciclos = Ciclo::all();
    //     $tiposExamen = Tipo_Examen::all();
    //     $aulas = Aula::all();
    //     $idperiodoSeleccionado = session('periodoSeleccionado');
    
    //     return view('notaExamen.notasAlumno', [
    //         'alumnos' => $alumnos,
    //         'periodos' => $periodos,
    //         'tiposCiclo' => $tiposCiclo,
    //         'areas' => $areas,
    //         'ciclos' => $ciclos,
    //         'tiposExamen' => $tiposExamen,
    //         'aulas' => $aulas,
    //         'idperiodoSeleccionado' => $idperiodoSeleccionado
    //     ]);
    // }
    
// public function verNotas($dniAlumno)
// {
//     // Obtener los datos del alumno
//     $alumno = Alumno::where('dniAlumno', $dniAlumno)->first();

//     // Si no se encuentra el alumno, redirigir a la lista de notas de examen con un mensaje de error
//     if (!$alumno) {
//         return redirect()->route('notaExamen.index')->with('error', 'Alumno no encontrado');
//     }

//     // Obtener las matrículas del alumno, junto con el aula y el ciclo asociado, ordenadas por fecha
//     $matriculas = Matricula::where('dniAlumno', $dniAlumno)
//         ->with(['aula.ciclo' => function($query) {
//             $query->orderBy('fechaInicio', 'desc');
//         }])
//         ->get();

//     // Inicializar el array para almacenar los periodos, ciclos y los exámenes por ciclo
//     $periodosConCiclos = [];

//     // Recorrer cada matrícula para obtener los ciclos y los exámenes del alumno
//     foreach ($matriculas as $matricula) {
//         $ciclo = $matricula->aula->ciclo;
//         $periodo = $ciclo->periodo;

//         if (!isset($periodosConCiclos[$periodo->idperiodo])) {
//             $periodosConCiclos[$periodo->idperiodo] = [
//                 'periodo' => $periodo,
//                 'ciclos' => []
//             ];
//         }

//         if (!isset($periodosConCiclos[$periodo->idperiodo]['ciclos'][$ciclo->idciclo])) {
//             // Obtener los exámenes del ciclo a través del aula, ordenados por fecha
//             $examenes = Examen::whereHas('aula', function ($query) use ($ciclo) {
//                     $query->where('idciclo', $ciclo->idciclo);
//                 })
//                 ->with(['notas' => function($query) use ($dniAlumno) {
//                     $query->whereHas('matricula', function($query) use ($dniAlumno) {
//                         $query->where('dniAlumno', $dniAlumno);
//                     });
//                 }])
//                 ->orderBy('fecha', 'desc')
//                 ->get();

//             // Almacenar el ciclo y los exámenes en el array
//             $periodosConCiclos[$periodo->idperiodo]['ciclos'][$ciclo->idciclo] = [
//                 'ciclo' => $ciclo,
//                 'examenes' => $examenes
//             ];
//         }
//     }

//     // Retornar la vista con los datos del alumno y los periodos con ciclos y exámenes
//     return view('notaExamen.verNotas', compact('alumno', 'periodosConCiclos'));
// }

public function verNotas($dniAlumno)
{
    // Obtener los datos del alumno
    $alumno = Alumno::where('dniAlumno', $dniAlumno)->first();

    // Si no se encuentra el alumno, redirigir a la lista de notas de examen con un mensaje de error
    if (!$alumno) {
        return redirect()->route('notaExamen.index')->with('error', 'Alumno no encontrado');
    }

    // Obtener las matrículas del alumno, junto con el aula y el ciclo asociado
    $matriculas = Matricula::where('dniAlumno', $dniAlumno)
        ->with(['aula.ciclo.periodo'])
        ->get();

    // Inicializar el array para almacenar los periodos, ciclos y los exámenes por ciclo
    $periodosConCiclos = [];

    // Recorrer cada matrícula para obtener los ciclos y los exámenes del alumno
    foreach ($matriculas as $matricula) {
        $ciclo = $matricula->aula->ciclo;
        $periodo = $ciclo->periodo;

        // Verificar si el periodo ya está en el array, si no, inicializarlo
        if (!isset($periodosConCiclos[$periodo->idperiodo])) {
            $periodosConCiclos[$periodo->idperiodo] = [
                'periodo' => $periodo,
                'ciclos' => []
            ];
        }

        // Verificar si el ciclo ya está en el array dentro del periodo, si no, obtener los exámenes
        if (!isset($periodosConCiclos[$periodo->idperiodo]['ciclos'][$ciclo->idciclo])) {
            // Obtener los exámenes del ciclo a través del aula, ordenados por fecha
            $examenes = Examen::whereHas('aula', function ($query) use ($ciclo) {
                    $query->where('idciclo', $ciclo->idciclo);
                })
                ->with(['notas' => function($query) use ($dniAlumno) {
                    $query->whereHas('matricula', function($query) use ($dniAlumno) {
                        $query->where('dniAlumno', $dniAlumno);
                    });
                }])
                ->orderBy('fecha', 'asc')
                ->get();

            // Almacenar el ciclo y los exámenes en el array
            $periodosConCiclos[$periodo->idperiodo]['ciclos'][$ciclo->idciclo] = [
                'ciclo' => $ciclo,
                'examenes' => $examenes
            ];
        }
    }

    // Ordenar los periodos por fechaInicio
    uasort($periodosConCiclos, function($a, $b) {
        return $a['periodo']->fechaInicio <=> $b['periodo']->fechaInicio;
    });

    // Ordenar los ciclos dentro de cada periodo por fechaInicio del ciclo
    foreach ($periodosConCiclos as &$periodoData) {
        uasort($periodoData['ciclos'], function($a, $b) {
            return $a['ciclo']->fechaInicio <=> $b['ciclo']->fechaInicio;
        });
    }

    // Retornar la vista con los datos del alumno y los periodos con ciclos y exámenes
    return view('notaExamen.verNotas', compact('alumno', 'periodosConCiclos'));
}


public function verNotasAulaAlumno($idaula, $dniAlumno)
{
    // Obtener el alumno
    $alumno = Alumno::where('dniAlumno', $dniAlumno)->first();

    // Si no se encuentra el alumno, redirigir a la lista de notas de examen con un mensaje de error
    if (!$alumno) {
        return redirect()->route('notaExamen.index')->with('error', 'Alumno no encontrado');
    }

    // Obtener la matrícula del alumno para el aula específico
    $matricula = Matricula::where('dniAlumno', $dniAlumno)
        ->where('idaula', $idaula)
        ->first();

    // Si no se encuentra la matrícula, redirigir a la lista de notas de examen con un mensaje de error
    if (!$matricula) {
        return redirect()->route('notaExamen.index')->with('error', 'Matrícula no encontrada para el aula especificada');
    }

    // Obtener los exámenes del aula, con las notas del alumno
    $examenes = Examen::whereHas('aula', function ($query) use ($idaula) {
            $query->where('idaula', $idaula);
        })
        ->with(['notas' => function($query) use ($dniAlumno) {
            $query->whereHas('matricula', function($query) use ($dniAlumno) {
                $query->where('dniAlumno', $dniAlumno);
            });
        }])
        ->orderBy('fecha', 'desc')
        ->get();

    // Verificar si se encontraron exámenes
    if ($examenes->isEmpty()) {
        return redirect()->route('notaExamen.index')->with('error', 'No hay notas disponibles para el alumno en el aula seleccionada.');
    }

    // Obtener detalles del aula para mostrar en la vista
    $aula = Aula::find($idaula);

    // Retornar la vista con los datos del alumno, el aula, y los exámenes
    return view('notaExamen.verNotasAulaAlumno', [
        'alumno' => $alumno,
        'aula' => $aula,
        'examenes' => $examenes
    ]);
}
public function graficoNotas($dniAlumno)
{
    // Obtener las matrículas del alumno por su DNI
    $matriculas = Matricula::where('dniAlumno', $dniAlumno)->get();

    // Si no se encuentran matrículas, devolver una respuesta vacía
    if ($matriculas->isEmpty()) {
        return response()->json([]);
    }

    // Obtener los números de matrícula
    $numerosMatricula = $matriculas->get('numMatricula');

    // Obtener las notas de todas las matrículas encontradas
    $notas = NotaExamen::whereIn('numMatricula', $numerosMatricula)
        ->get(['fecha', 'notaaptitud', 'notaconocimientos', 'notatotal']);

    return response()->json($notas);
}

public function graficoNotasAlumnoLineal($dniAlumno)
{
    // Obtener los datos del alumno
    $alumno = Alumno::where('dniAlumno', $dniAlumno)->first();

    // Si no se encuentra el alumno, retornar un error en JSON
    if (!$alumno) {
        return response()->json(['error' => 'Alumno no encontrado'], 404);
    }

    // Obtener las matrículas del alumno, junto con el aula y el ciclo asociado
    $matriculas = Matricula::where('dniAlumno', $dniAlumno)
        ->with(['aula.ciclo' => function($query) {
            $query->orderBy('fechaInicio', 'asc');
        }])
        ->get();

    // Inicializar el array para almacenar las notas
    $notas = [];

    // Recorrer cada matrícula para obtener los ciclos y los exámenes del alumno
    foreach ($matriculas as $matricula) {
        $ciclo = $matricula->aula->ciclo;

        // Obtener los exámenes del ciclo a través del aula, ordenados por fecha
        $examenes = Examen::whereHas('aula', function ($query) use ($ciclo) {
                $query->where('idciclo', $ciclo->idciclo);
            })
            ->with(['notas' => function($query) use ($dniAlumno) {
                $query->whereHas('matricula', function($query) use ($dniAlumno) {
                    $query->where('dniAlumno', $dniAlumno);
                });
            }])
            ->orderBy('fecha', 'asc')
            ->get();

        // Almacenar las notas de cada examen
        foreach ($examenes as $examen) {
            $nota = $examen->notas->first();
            if ($nota) {
                $notas[] = [
                    'ciclo' => $examen->aula->ciclo->descripcion,
                    'aula' => $examen->aula->descripcion,
                    'fecha' => $examen->fecha,
                    'notaaptitud' => $nota->notaaptitud,
                    'notaconocimientos' => $nota->notaconocimientos,
                    'notatotal' => $nota->notatotal
                ];
            }
        }
    }

    // Ordenar el array de notas por fecha
    usort($notas, function($a, $b) {
        return strtotime($a['fecha']) - strtotime($b['fecha']);
    });



    // Retornar los datos en formato JSON
    return response()->json($notas);
}

private function saveDurationToCsvAlumno($startTime, $endTime, $durationInSeconds)
{
    $filePath = public_path('images/reporteIndividual.csv'); // Ruta correcta para la carpeta pública

    // Crear la carpeta si no existe
    $directory = public_path('images');
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }

    // Abre el archivo en modo de adición
    $file = fopen($filePath, 'a');

    // Si el archivo está vacío, escribe la cabecera
    if (filesize($filePath) === 0) {
        fputcsv($file, ['Tiempo inicial', 'Tiempo final', 'Duración (segundos)']);
    }

    // Escribe la fila de datos
    fputcsv($file, [$startTime, $endTime, $durationInSeconds]);

    // Cierra el archivo
    fclose($file);
}

public function generarPdf(Request $request, $dniAlumno)
{
    // Obtener los datos necesarios
    $alumno = Alumno::where('dniAlumno', $dniAlumno)->first();

    if (!$alumno) {
        return redirect()->route('notaExamen.index')->with('error', 'Alumno no encontrado');
    }

    $matriculas = Matricula::where('dniAlumno', $dniAlumno)
        ->with(['aula.ciclo.periodo'])
        ->get();

    $periodosConCiclos = [];

    foreach ($matriculas as $matricula) {
        $ciclo = $matricula->aula->ciclo;
        $periodo = $ciclo->periodo;

        if (!isset($periodosConCiclos[$periodo->idperiodo])) {
            $periodosConCiclos[$periodo->idperiodo] = [
                'periodo' => $periodo,
                'ciclos' => []
            ];
        }

        if (!isset($periodosConCiclos[$periodo->idperiodo]['ciclos'][$ciclo->idciclo])) {
            $examenes = Examen::whereHas('aula', function ($query) use ($ciclo) {
                    $query->where('idciclo', $ciclo->idciclo);
                })
                ->with(['notas' => function($query) use ($dniAlumno) {
                    $query->whereHas('matricula', function($query) use ($dniAlumno) {
                        $query->where('dniAlumno', $dniAlumno);
                    });
                }])
                ->orderBy('fecha', 'asc')
                ->get();

            $periodosConCiclos[$periodo->idperiodo]['ciclos'][$ciclo->idciclo] = [
                'ciclo' => $ciclo,
                'examenes' => $examenes
            ];
        }
    }

    // Ordenar los periodos y ciclos
    uasort($periodosConCiclos, function($a, $b) {
        return $a['periodo']->fechaInicio <=> $b['periodo']->fechaInicio;
    });

    foreach ($periodosConCiclos as &$periodoData) {
        uasort($periodoData['ciclos'], function($a, $b) {
            return $a['ciclo']->fechaInicio <=> $b['ciclo']->fechaInicio;
        });
    }

    $chartImage = $request->input('chartImage');

    // Cargar la vista para el PDF
    $pdf = Pdf::loadView('notaExamen.pdfNotas', compact('alumno', 'periodosConCiclos', 'chartImage'));

    // Calcular la duración en segundos
    $startTime = session('start_notas_alumnos_time');
    if ($startTime) {
        $startTime = new \DateTime($startTime);
        $endTime = new \DateTime();
        $interval = $startTime->diff($endTime);

        // Convertir la diferencia en segundos
        $durationInSeconds = ($interval->days * 24 * 60 * 60) // Días en segundos
            + ($interval->h * 60 * 60) // Horas en segundos
            + ($interval->i * 60) // Minutos en segundos
            + $interval->s; // Segundos

        // Guardar la duración en el archivo CSV
        $this->saveDurationToCsvAlumno($startTime->format('Y-m-d H:i:s'), $endTime->format('Y-m-d H:i:s'), $durationInSeconds);

        // Limpiar el tiempo de inicio de la sesión
        session()->forget('start_notas_alumnos_time');
    }

    // Descargar el PDF con un nombre específico
    return $pdf->stream('notas_alumno_' . $alumno->dniAlumno . '.pdf');

}

}
