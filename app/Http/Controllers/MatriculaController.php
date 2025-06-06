<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Matricula;
use App\Models\Ciclo;
use App\Models\Periodo;
use App\Models\EstadoCivil;
use App\Models\Tipo_Ciclo;
use App\Models\Carrera;
use App\Models\Area;
use App\Models\Apoderado;
use App\Models\Aula;
use App\Models\Pago;
use App\Models\MedioPago;
use App\Models\Examen;
use App\Models\Tipo_Examen;
use App\Models\NotaExamen;
use App\Models\Cursoo;
use App\Models\Catedra;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MatriculaController extends Controller
{
    const PAGINATION = 10;
    public function index(Request $request)
    {
        // Obtener filtros
        $idperiodo = $request->input('idperiodo');
        $idtipociclo = $request->input('idtipociclo');
        $idarea = $request->input('idarea');
        $idciclo = $request->input('idciclo');
        $idtipoexamen = $request->input('idtipoexamen');
        $idaula = $request->input('idaula');
        $buscarpor = $request->input('buscarpor');
    
        // Construcción de la consulta base
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
            'matriculas.fechaMatricula',
            'matriculas.horaMatricula'
        )
        ->join('matriculas', 'alumnos.dniAlumno', '=', 'matriculas.dniAlumno')
        ->join('aula', 'matriculas.idaula', '=', 'aula.idaula')
        ->join('ciclo', 'aula.idciclo', '=', 'ciclo.idciclo')
        ->join('area', 'ciclo.idarea', '=', 'area.idarea')
        ->join('tipo_ciclo', 'ciclo.idtipociclo', '=', 'tipo_ciclo.idtipociclo')
        ->join('periodo', 'ciclo.idperiodo', '=', 'periodo.idperiodo')
        ->where('matriculas.estado', 1)
        ->distinct()
        ->when($idperiodo, fn($q) => $q->where('ciclo.idperiodo', $idperiodo))
        ->when($idtipociclo, fn($q) => $q->where('ciclo.idtipociclo', $idtipociclo))
        ->when($idarea, fn($q) => $q->where('ciclo.idarea', $idarea))
        ->when($idciclo, fn($q) => $q->where('ciclo.idciclo', $idciclo))
        ->when($idaula, fn($q) => $q->where('aula.idaula', $idaula))
        ->when($buscarpor, function ($q) use ($buscarpor) {
            $q->where(function ($sub) use ($buscarpor) {
                $sub->where('alumnos.dniAlumno', 'LIKE', "%$buscarpor%")
                    ->orWhere('alumnos.nombres', 'LIKE', "%$buscarpor%")
                    ->orWhere('alumnos.apellidos', 'LIKE', "%$buscarpor%");
            });
        })
        ->orderBy('matriculas.fechaMatricula', 'desc')
        ->orderBy('matriculas.horaMatricula', 'desc');
    
        // Obtener todos los registros y agregar URL temporal
        $items = $query->get()->map(function ($item) {
            if ($item->featured) {
                $item->urlTemporal = Storage::disk('s3')->temporaryUrl(
                    $item->featured,
                    now()->addMinutes(15)
                );
            } else {
                $item->urlTemporal = null;
            }
            return $item;
        });
    
        // Paginación manual
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $currentItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $matriculas = new LengthAwarePaginator($currentItems, $items->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => $request->query(),
        ]);
    
        // Datos para filtros
        $periodos = Periodo::where('estado', 1)->get();
        $tiposCiclo = Tipo_Ciclo::all();
        $areas = Area::all();
        $ciclos = Ciclo::all();
        $aulas = Aula::all();
        $tiposExamen = Tipo_Examen::all();
        $idperiodoSeleccionado = session('periodoSeleccionado');
    
        return view('matriculas.index', [
            'matriculas' => $matriculas,
            'periodos' => $periodos,
            'tiposCiclo' => $tiposCiclo,
            'areas' => $areas,
            'ciclos' => $ciclos,
            'aulas' => $aulas,
            'tiposExamen' => $tiposExamen,
            'idperiodoSeleccionado' => $idperiodoSeleccionado,
            'buscarpor' => $buscarpor
        ]);
    }

    

    public function pdf($numMatricula)
    {
        $matricula = Matricula::with('ciclo', 'alumno.apoderado.estadoCivil')
            ->where('numMatricula', '=', $numMatricula)
            ->firstOrFail();
        
        $periodo = $matricula->ciclo->periodo;
        $alumno = $matricula->alumno;
        $apoderado = $alumno->apoderado;
        
        $pdf = Pdf::loadView('matriculas.lista', compact('matricula', 'periodo', 'alumno', 'apoderado'));
        return $pdf->stream('lista.pdf');
    }

    public function create()
    {
        // Obtener todos los periodos, tipos de ciclo y áreas
        session(['start_time' => now()->toDateTimeString()]);

        $periodos = Periodo::all()->where('estado', '=', 1);
        $tiposCiclo = Tipo_Ciclo::all();
        $areas = Area::all();
        $carreras = Carrera::all(); // Obtener las carreras disponibles
        $idperiodoSeleccionado = session('periodoSeleccionado');
        $medioPago = MedioPago::all();
        // Pasar los datos a la vista
        return view('matriculas.create', [
            'periodos' => $periodos,
            'tiposCiclo' => $tiposCiclo,
            'areas' => $areas,
            'carreras' => $carreras,
            'mediopago' => $medioPago,
            'idperiodoSeleccionado' => $idperiodoSeleccionado
        ]);
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'idperiodo'=> 'required',
        'idaula' => 'required',
        'idciclo' => 'required',
        'apellidosAlumno' => 'required',
        'nombresAlumno' => 'required',
        'dniAlumno' => 'required',
        'fechaNacimiento' => 'required|date',
        'idcarrera'=> 'required',
        'featured' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'nropago' => 'required|string|max:255',
        'fecha' => 'required|date',
        'monto' => 'required|numeric',
        'idmediopago' => 'required',
        'rutaImagen' => 'required|image|max:2048',
    ], [
        'idciclo.required' => 'Seleccione Ciclo',
        'apellidosAlumno.required' => 'Ingrese apellidos del alumno',
        'nombresAlumno.required' => 'Ingrese nombre del alumno',
        'dniAlumno.required' => 'Ingrese DNI del alumno',
        'fechaNacimiento.required' => 'Ingrese fecha de nacimiento del alumno',
        'featured.image' => 'El archivo debe ser una imagen',
        'featured.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg, gif o svg',
        'featured.max' => 'El tamaño máximo de la imagen es de 2MB',
    ]);

    $alumnoExistente = Alumno::where('dniAlumno', $request->dniAlumno)->first();

    if (!$alumnoExistente) {
        $alumno = new Alumno();
        $alumno->dniAlumno = $request->dniAlumno;
        $alumno->apellidos = $request->apellidosAlumno;
        $alumno->nombres = $request->nombresAlumno;
        $alumno->edad = Carbon::parse($request->fechaNacimiento)->age; 
        $alumno->dniApoderado = '12444444'; 
        $alumno->estado = '1';
        $alumno->fechaNacimiento = $request->fechaNacimiento;
        $alumno->idcarrera = $request->idcarrera;
        if ($request->hasFile('featured')) {
            $file = $request->file('featured');
            $filename = 'alumnos/' . time() . '-' . $file->getClientOriginalName();
        
            Storage::disk('s3')->put($filename, file_get_contents($file));
        
            $alumno->featured = $filename;
        }
        
        $alumno->save();
    } else {
        $alumno = $alumnoExistente;
    }


    $matricula = new Matricula();
    $matricula->fechaMatricula = now()->toDateString();
    $matricula->horaMatricula = now()->toTimeString(); 
    $matricula->idciclo = $request->idciclo;
    $matricula->dniAlumno = $request->dniAlumno;
    $matricula->idaula = $request->idaula;
    $matricula->estado = '1'; 

    $matricula->save();
    
    $pago = new Pago();
    $pago->nropago = $request->nropago;
    $pago->fecha = $request->fecha;
    $pago->monto = $request->monto;
    $pago->idmediopago = $request->idmediopago;
    $pago->numMatricula = $matricula->numMatricula;


    if ($request->hasFile('rutaImagen')) {
        $file = $request->file('rutaImagen');
        $filename = 'pagos/' . time() . '-' . $file->getClientOriginalName();
    
        Storage::disk('s3')->put($filename, file_get_contents($file));
    
        $pago->rutaImagen = $filename;
    }


    $pago->estado = 'Pendiente';
    $pago->save();



    $startTime = new \DateTime(session('start_time'));
    $endTime = new \DateTime();

    // Calcular la diferencia
    $interval = $startTime->diff($endTime);

    // Convertir la diferencia en segundos
    $durationInSeconds = ($interval->days * 24 * 60 * 60) // Días en segundos
        + ($interval->h * 60 * 60) // Horas en segundos
        + ($interval->i * 60) // Minutos en segundos
        + $interval->s; // Segundos

    // Procesar y guardar los datos de la matrícula
    // ...

    // Guardar los datos en un archivo CSV
    $this->saveToCsv($startTime->format('Y-m-d H:i:s'), $endTime->format('Y-m-d H:i:s'), $durationInSeconds);


    // Limpiar el tiempo de inicio de la sesión
    session()->forget('start_time');



    // Redireccionar al usuario a la página de índice de matrículas con un mensaje de éxito
    return redirect()->route('matriculas.index')->with('datos', 'Registro Nuevo Guardado...!');
}

private function saveToCsv($startTime, $endTime, $duration)
{
    // Ruta correcta para la carpeta pública
    $filePath = public_path('images/matriculas.csv');

    // Crear la carpeta si no existe
    $directory = public_path('images');
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }

    // Abre el archivo en modo de adición
    $file = fopen($filePath, 'a');

    // Si el archivo está vacío, escribe la cabecera
    if (filesize($filePath) === 0) {
        fputcsv($file, ['Start Time', 'End Time', 'Duration']);
    }

    // Escribe la fila de datos
    fputcsv($file, [$startTime, $endTime, $duration]);

    // Cierra el archivo
    fclose($file);
}



public function edit($numMatricula)
{
    // Obtener la matrícula y los datos necesarios para el formulario
    $matricula = Matricula::findOrFail($numMatricula);
    $periodos = Periodo::all();
    $tiposCiclo = Tipo_Ciclo::all();
    $areas = Area::all();
    $carreras = Carrera::all();
    $ciclos = Ciclo::all();
    $aulas = Aula::all();
    $idperiodoSeleccionado = session('periodoSeleccionado');
    $mediopago = MedioPago::all();

    // Obtener los pagos asociados a la matrícula con URL temporal
    $pagos = $matricula->pagos->map(function ($pago) {
        if ($pago->rutaImagen) {
            $pago->urlTemporal = Storage::disk('s3')->temporaryUrl(
                $pago->rutaImagen,
                now()->addMinutes(15)
            );
        } else {
            $pago->urlTemporal = null;
        }
        return $pago;
    });

    // Obtener alumno y generar URL temporal de su foto
    $alumno = $matricula->alumno;
    if ($alumno && $alumno->featured) {
        $alumno->urlFotoTemporal = Storage::disk('s3')->temporaryUrl(
            $alumno->featured,
            now()->addMinutes(15)
        );
    }

    return view('matriculas.edit', compact(
        'matricula',
        'periodos',
        'tiposCiclo',
        'areas',
        'carreras',
        'ciclos',
        'aulas',
        'idperiodoSeleccionado',
        'mediopago',
        'pagos',
        'alumno'
    ));
}

public function update(Request $request, $numMatricula)
{
    $request->validate([
        'idtipociclo' => 'required',
        'idarea' => 'required',
        'idciclo' => 'required',
        'idaula' => 'required',
        'dniAlumno' => 'required',
        'apellidosAlumno' => 'required',
        'nombresAlumno' => 'required',
        'fechaNacimiento' => 'required',
        'idcarrera' => 'required',
        'featured' => 'nullable|image|mimes:jpeg,png|max:2048',
        'idpago.*' => 'nullable|integer|exists:pago,idpago',
        'nropago.*' => 'required_with:idpago.*|numeric',
        'fechaPago.*' => 'required_with:idpago.*|date',
        'montoPago.*' => 'required_with:idpago.*|numeric',
        'idmediopago.*' => 'required_with:idpago.*|integer',
        'estadoPago.*' => 'required_with:idpago.*|in:pendiente,confirmado,cancelado',
        'rutaImagen.*' => 'nullable|image|mimes:jpeg,png|max:2048',
    ]);

    $matricula = Matricula::findOrFail($numMatricula);
    $matricula->dniAlumno = $request->dniAlumno;
    $matricula->idaula = $request->idaula;
    $matricula->idciclo = $request->idciclo;
    $matricula->save();

    foreach ($request->idpago as $index => $idpago) {
        if ($idpago) {
            $pago = Pago::findOrFail($idpago);
        } else {
            $pago = new Pago();
            $pago->numMatricula = $numMatricula;
        }

        $pago->nropago = $request->nropago[$index];
        $pago->fecha = $request->fechaPago[$index];
        $pago->monto = $request->montoPago[$index];
        $pago->idmediopago = $request->idmediopago[$index];
        $pago->estado = $request->estadoPago[$index];

        if ($request->hasFile('rutaImagen.' . $index)) {
            $file = $request->file('rutaImagen.' . $index);
            $filename = 'pagos/' . time() . '-' . $file->getClientOriginalName();
            Storage::disk('s3')->put($filename, file_get_contents($file));

            $pago->rutaImagen = $filename;
        }

        $pago->save();
    }

    $alumno = Alumno::findOrFail($matricula->dniAlumno);
    $alumno->dniAlumno = $request->dniAlumno;
    $alumno->apellidos = $request->apellidosAlumno;
    $alumno->nombres = $request->nombresAlumno;
    $alumno->fechaNacimiento = $request->fechaNacimiento;
    $alumno->idcarrera = $request->idcarrera;

    if ($request->hasFile('featured')) {
        $file = $request->file('featured');
        $filename = 'alumnos/' . time() . '-' . $file->getClientOriginalName();
        Storage::disk('s3')->put($filename, file_get_contents($file));

        $alumno->featured = $filename;
    }

    $alumno->save();

    return redirect()->route('matriculas.index')->with('success', 'Matrícula y datos del alumno actualizados con éxito');
}





    public function confirmar($numMatricula)
    {
        $matricula = Matricula::findOrFail($numMatricula);

        return view('matriculas.confirmar', compact('matricula'));
    }

    public function destroy(string $id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->estado = '0'; // Cambiar el estado a '0' en lugar de eliminar
        $matricula->save();

        return redirect()->route('matriculas.index')->with('datos', 'Registro Eliminado...!');
    }

    // Nuevas funciones para cargar datos dinámicos

    public function cargarTiposCiclo($idperiodo)
    {
        $tiposCiclo = Tipo_Ciclo::where('idperiodo', $idperiodo)->get();
        return response()->json($tiposCiclo);
    }

    public function cargarAreas($idperiodo, $idtipociclo)
    {
        $areas = Area::whereHas('ciclos', function ($query) use ($idperiodo, $idtipociclo) {
            $query->where('idperiodo', $idperiodo)
                  ->where('idtipociclo', $idtipociclo);
        })->get();
        return response()->json($areas);
    }

    public function cargarCiclos($idperiodo, $idtipociclo, $idarea)
    {
        $ciclos = Ciclo::where('idperiodo', $idperiodo)
                        ->where('idtipociclo', $idtipociclo)
                        ->where('idarea', $idarea)
                        ->get();
        return response()->json($ciclos);
    }

    public function cargarAulas($idciclo)
    {
        $aulas = Aula::where('idciclo', $idciclo)->get();
        return response()->json($aulas);
    }

    // public function cargarDocentes($idaula)
    // {
    //     // Buscar los docentes asociados al aula especificada
    //     $docentes = Catedra::with(['docente', 'curso'])
    //         ->where('idaula', $idaula)
    //         ->get()
    //         ->map(function ($catedra) {
    //             return [
    //                 'codDocente' => $catedra->docente->codDocente,
    //                 'nombreCompleto' => $catedra->docente->nombres . ' ' . $catedra->docente->apellidos,
    //                 'curso' => $catedra->curso->descripcion,
    //             ];
    //         });

    //     // Devolver los datos en formato JSON
    //     return response()->json(['docentes' => $docentes]);
    // }
    public function cargarDocentes($idaula)
    {
        // Buscar los docentes asociados al aula especificada con paginación
        $paginador = Catedra::with(['docente', 'curso'])
            ->where('idaula', $idaula)
            ->paginate(4); // Cambia 10 por el número de docentes por página
    
        // Mapear los datos para devolver en formato JSON
        $docentes = $paginador->map(function ($catedra) {
            return [
                'codDocente' => $catedra->docente->codDocente,
                'nombreCompleto' => $catedra->docente->nombres . ' ' . $catedra->docente->apellidos,
                'curso' => $catedra->curso->descripcion,
            ];
        });
    
        // Devolver los datos en formato JSON con información de paginación
        return response()->json([
            'data' => $docentes,
            'current_page' => $paginador->currentPage(),
            'total_pages' => $paginador->lastPage(),
            'prev_page_url' => $paginador->previousPageUrl(),
            'next_page_url' => $paginador->nextPageUrl(),
            'total' => $paginador->total()
        ]);
    }
    

    public function generarFichaPDF($numMatricula)
    {
        // Obtener la matrícula con los datos necesarios
        $matricula = Matricula::with(['alumno', 'aula.ciclo.area', 'aula.ciclo.periodo', 'aula.ciclo.tipo_ciclo', 'aula.catedras.docente'])
                              ->where('numMatricula', $numMatricula)
                              ->first();

        // Verificar que la matrícula exista
        if (!$matricula) {
            return redirect()->route('matriculas.index')->with('error', 'Matrícula no encontrada');
        }


        $pdf = Pdf::loadView('matriculas.ficha_pdf', compact('matricula'));
    
        // return $pdf->stream('notas_examen_' . $examen->idexamen . '.pdf');

        
        // // Cargar la vista con los datos
        // $pdf = new Dompdf();
        // $pdf->loadHtml(view('matriculas.ficha_pdf', compact('matricula'))->render());

        // // Configurar tamaño y orientación del PDF
        // $pdf->setPaper('A4', 'portrait');

        // // Renderizar el PDF
        // $pdf->render();

        // Descargar el PDF
        return $pdf->stream('ficha_matricula_' . $matricula->numMatricula . '.pdf');
    }
    

}
