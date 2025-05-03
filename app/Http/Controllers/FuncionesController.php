<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Capacidad;
use App\Models\Docente;
use App\Models\Docente_Curso;
use App\Models\Grado;
use App\Models\Nivel;
use App\Models\Trimestre;
use App\Models\Ciclo;
use App\Models\Carrera;
use App\Models\Tipo_Ciclo;
use App\Models\Aula;
use App\Models\Area;
use App\Models\Nota;
use App\Models\Seccion;
use Illuminate\Http\Request;

class FuncionesController extends Controller
{
    //
    public function PorNivel($idNivel)
    {
        $grados = Grado::where('idNivel', $idNivel)->get();
        return response()->json($grados);
    }

    public function obtenerTrimestrePorPeriodo($idperiodo)
    {
      $trimestres = Trimestre::where('idperiodo', $idperiodo)->get(); // Asumiendo que la relación es con el campo 'idperiodo'
      return response()->json($trimestres);
    }
    
    


    public function VerDocente($codDocente)
    {
        // Obtener los datos del docente desde la tabla Docente según el $codDocente recibido
        $docente = Docente::where('codDocente', $codDocente)->first();
    
        // Retornar los datos del docente como una respuesta JSON
        return response()->json($docente);
    }
    
    public function VerCurso($idNivel)
    {
        // Obtener los cursos desde la tabla Curso según el $idNivel recibido
        $cursos = Curso::where('idNivel', $idNivel)->where('estado','=','1')->get();
    
        // Retornar los cursos como una respuesta JSON
        return response()->json($cursos);
    }

    public function VerNivel($idNivel)
    {
        $nivel = Nivel::findOrFail($idNivel);
        return response()->json($nivel);
    }

    public function VerSeccion($idGrado, $idperiodo)
    {
        $seccion = Seccion::where('idGrado', $idGrado)
        ->where('idperiodo','=',$idperiodo)
        ->where('estado','=','1')->get();
        return response()->json($seccion);
    }
    
    public function obtenerDocenteCurso($codDocente)
    {
        $docenteCurso = Docente_Curso::where('codDocente', $codDocente)
            ->with(['curso', 'grado', 'seccion'])
            ->get();

        return response()->json($docenteCurso);
    }

    public function obtenerCapacidadesPorCurso($idCurso)
    {
      $capacidades = Capacidad::where('idCurso', $idCurso)->get();
      return response()->json($capacidades);
    }
    
    public function NivelPorAnyo()
    {
        $nivel = Nivel::all();
        return response()->json($nivel);
    }

    public function obtenerDocentePorCurso($idCurso, $idperiodo, $idSeccion, $idGrado)
    {
        $docenteCurso = Docente_Curso::where('idCurso', $idCurso)
            ->where('idperiodo', $idperiodo)
            ->where('idSeccion', $idSeccion)
            ->where('idGrado', $idGrado)
            ->first();

        if ($docenteCurso != null && $docenteCurso->exists()) {
            return response()->json(Docente::find($docenteCurso->codDocente));
        }

        return response()->json(null); // Retorna una respuesta JSON nula si no se encuentra el docente
    }

    public function guardarNota($dniAlumno, $unidad1,$unidad2,$unidad3,$unidad4,$exonerar,$idperiodo,$idCapacidad,$idGrado,$idSeccion,$idCurso)
    {
        $nota = Nota::where('dniAlumno','=',$dniAlumno)
            ->where('idperiodo','=',$idperiodo)
            ->where('idCapacidad','=',$idCapacidad)
            ->where('idGrado','=',$idGrado)
            ->where('idSeccion','=',$idSeccion)
            ->first();

        if ($nota != null && $nota->exists) 
        {
            $nota->unidad1 = $unidad1;
            $nota->unidad2 = $unidad2;
            $nota->unidad3 = $unidad3;
            $nota->unidad4 = $unidad4;
            $nota->exonerar = $exonerar;
            $nota->save();
        }
        else{
            $nota = new Nota();
            $nota->dniAlumno = $dniAlumno;
            $nota->idperiodo = $idperiodo;
            $nota->idCapacidad = $idCapacidad;
            $nota->idGrado = $idGrado;
            $nota->idSeccion = $idSeccion;
            $nota->idCurso = $idCurso;
            $nota->unidad1 = $unidad1;
            $nota->unidad2 = $unidad2;
            $nota->unidad3 = $unidad3;
            $nota->unidad4 = $unidad4;
            $nota->exonerar = $exonerar;
            $nota->save();
        }

        return response()->json(['message' => 'Nota guardada exitosamente']);
    }

    public function cargarTipoCiclos()
    {
        $tiposCiclo = Tipo_Ciclo::all();
        return response()->json(['tiposCiclo' => $tiposCiclo]);
    }

    // Método para cargar áreas
    // public function cargarAreas()
    // {
    //     $areas = Area::all();
    //     return response()->json(['areas' => $areas]);
    // }

    public function cargarAreas($idperiodo, $idtipociclo)
    {
        // Obtén los IDs de las áreas relacionadas con el período y tipo de ciclo seleccionados
        $areas = Ciclo::where('idperiodo', $idperiodo)
                      ->where('idtipociclo', $idtipociclo)
                      ->pluck('idarea')
                      ->unique();

        // Obtén las áreas correspondientes
        $areas = Area::whereIn('idarea', $areas)->get();

        return response()->json($areas);
    }

    public function cargarTiposCiclo($idperiodo)
    {
        // Obtener los idtipociclo únicos de los ciclos del periodo
        $tiposCiclo = Ciclo::where('idperiodo', $idperiodo)
            ->distinct('idtipociclo')
            ->pluck('idtipociclo');

        // Obtener la descripción de cada idtipociclo
        $tiposCicloDescripcion = Tipo_Ciclo::whereIn('idtipociclo', $tiposCiclo)
            ->get(['idtipociclo', 'descripcion']);

        return response()->json($tiposCicloDescripcion);
    }

    // Método para cargar ciclos basado en periodo, tipo de ciclo y área
    public function cargarCiclos($idperiodo, $idtipociclo, $idarea)
    {

        $ciclo = Ciclo::where('idperiodo', $idperiodo)
                ->where('idtipociclo', $idtipociclo)
                ->where('idarea', $idarea)
                ->get();

            return response()->json($ciclo);
    }

    // Método para cargar aulas basado en el id del ciclo
    public function cargarAulas($cicloId)
    {
        $aulas = Aula::where('idciclo', $cicloId)->get();
        return response()->json(['aulas' => $aulas]);
    }

    public function cargarCarreras($idarea)
    {
        // Obtener las carreras relacionadas con el área seleccionada
        $carreras = Carrera::where('idarea', $idarea)->get();

        // Retornar los datos como JSON
        return response()->json($carreras);
    }
}
