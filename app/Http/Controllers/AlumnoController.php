<?php

namespace App\Http\Controllers;

use App\Models\Alumno_Seccion;
use App\Models\Periodo;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\Nivel;
use App\Models\Seccion;
use App\Models\Examen;
use App\Models\Tipo_Examen;
use App\Models\Tipo_Ciclo;
use App\Models\Area;
use App\Models\Ciclo;
use App\Models\Aula;
use App\Models\NotaExamen;
use App\Models\Alumno;

use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $alumnos = null;
        
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
                        $grados = [1, 2, 3]; //Grados del nivel inicial
                        $alumnos = Matricula::where('idperiodo', '=', $request->idperiodo)
                            ->whereIn('idGrado', $grados)
                            ->where('estado', '=', '1')
                            ->paginate($this::PAGINATION);
                    }
                    if($request->idNivel == '2')
                    {
                        $grados = [4, 5, 6, 7, 8, 9]; //Grados del nivel inicial
                        $alumnos = Matricula::where('idperiodo', '=', $request->idperiodo)
                            ->whereIn('idGrado', $grados)
                            ->where('estado', '=', '1')
                            ->paginate($this::PAGINATION);
                    }
                    if($request->idNivel == '3')
                    {
                        $grados = [10, 11, 12, 13, 14,]; //Grados del nivel inicial
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

        return view('alumnos.index', compact('alumnos','periodo','request', 'nivelEscolar', 'grado', 'seccion'));
    }

    public function periodoEscolar(Request $request)
    {
        $periodo = Periodo::findOrFail($request->idAnyo);
        return redirect()->route('alumnos.listar', $periodo->idAnyo);
    }

    public function cargarAlumnos($cicloId, $aulaId)
{
    $alumnos = Alumno::select(
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
            'periodo.idperiodo'
        )
        ->join('matriculas', 'alumnos.dniAlumno', '=', 'matriculas.dniAlumno')
        ->join('aula', 'matriculas.idaula', '=', 'aula.idaula')
        ->join('ciclo', 'aula.idciclo', '=', 'ciclo.idciclo')
        ->join('area', 'ciclo.idarea', '=', 'area.idarea')
        ->join('tipo_ciclo', 'ciclo.idtipociclo', '=', 'tipo_ciclo.idtipociclo')
        ->join('periodo', 'ciclo.idperiodo', '=', 'periodo.idperiodo')
        ->where('ciclo.idciclo', $cicloId)
        ->where('aula.idaula', $aulaId)
        ->where('matriculas.estado', 1)
        ->orderBy('alumnos.apellidos', 'asc') 
        ->orderBy('alumnos.nombres', 'asc') 
        ->distinct()
        ->get();

            // Asegúrate de que `featured` contiene la ruta correcta.
        $alumnos->each(function ($alumno) {
            $alumno->featured = asset($alumno->featured);
        });

    return response()->json(['alumnos' => $alumnos]);
}


    public function listar(Request $request, string $idAnyo)
    {
        
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
