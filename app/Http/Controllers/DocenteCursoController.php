<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Docente_Curso;
use App\Models\Grado;
use App\Models\Seccion;
use Illuminate\Http\Request;

class DocenteCursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     const PAGINATION = 10;

    public function index(Request $request)
    {
        $idperiodo = session('periodoSeleccionado');
        
        $query = Docente_Curso::query()
        ->where('idperiodo', $idperiodo); // Filter by session period

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('docente', function ($q) use ($search) {
                $q->whereRaw("CONCAT(apellidos, ' ', nombres) LIKE ?", ["%$search%"]);
            });
        }
        $docenteCurso = $query->paginate(10);
        return view('docenteCurso.index', compact('docenteCurso'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $docentes = Docente::where('estado','=','1')->get();
        $periodo = Periodo::all();
        return view('docenteCurso.create', compact('docentes', 'periodo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = request()->validate([
            'codDocente' => 'required',
            'idperiodo' => 'required',
            'idCurso' => 'required',
            'idGrado' => 'required',
            'idSeccion' => 'required'
        ],
        [
            'codDocente.required'=>'Seleccione docente',
            'idperiodo.required'=>'Seleccione año escolar',
            'idCurso.required'=>'Seleccione curso',
            'idGrado.required'=>'Seleccione grado',
            'idSeccion.required'=>'Seleccione seccion'
        ]);

        $docenteCurso = new Docente_Curso;
        $docenteCurso->codDocente = $request->codDocente;
        $docenteCurso->idCurso = $request->idCurso;
        $docenteCurso->idperiodo = $request->idperiodo;
        $docenteCurso->idSeccion = $request->idSeccion;
        $docenteCurso->idGrado = $request->idGrado;
        $docenteCurso->estado = '1';
        $docenteCurso->save();

        //return response()->json($docenteCurso);

        return redirect()->route('docenteCurso.index')->with('datos', '¡Nueva cátedra creada!');
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
    public function editar($id, $codDocente, $idCurso ,$idperiodo)
    {
        $docente_curso = Docente_Curso::where('estado', '=', '1')
            ->where('idperiodo', '=', $idperiodo)
            ->where('idCurso', '=', $idCurso)
            ->where('codDocente', '=', $codDocente)
            ->with(['anyoescolar','docente', 'curso'])
            ->first();
        $periodo = Periodo::all();
        $docentes = Docente::where('estado','=','1')->get();


        return view('docenteCurso.edit', compact('docente_curso','periodo', 'docentes'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $codDocente, $idCurso, $idperiodo)
    {
        $data = request()->validate([
            'idperiodo' => 'required',
            'idCurso' => 'required',
            'idGrado' => 'required',
            'idSeccion' => 'required'
        ],
        [
            'idperiodo.required'=>'Seleccione año escolar',
            'idCurso.required'=>'Seleccione curso',
            'idGrado.required'=>'Seleccione grado',
            'idSeccion.required'=>'Seleccione seccion'
        ]);


        $docenteCurso = Docente_Curso::where('id', $id)
            ->where('codDocente', $codDocente)
            ->where('idCurso', $idCurso)
            ->where('idperiodo', $idperiodo)
            ->update([
                'idCurso' => $data['idCurso'],
                'idperiodo' => $data['idperiodo'],
                'idSeccion' => $data['idSeccion'],
                'idGrado' => $data['idGrado'],
            ]);


        return redirect()->route('docenteCurso.index')->with('datos', '¡Cátedra actualizada correctamente!');
    }

    public function confirmar($id, $codDocente, $idCurso, $idperiodo)
{
    // Obtén el registro que deseas eliminar
    $docenteCurso = Docente_Curso::where('id', $id)
        ->where('codDocente', $codDocente)
        ->where('idCurso', $idCurso)
        ->where('idperiodo', $idperiodo)
        ->first();

    return view('docenteCurso.confirmar', compact('docenteCurso'));
}

public function eliminar($id, $codDocente, $idCurso, $idperiodo)
{
    // Obtén el registro que deseas eliminar
    $docenteCurso = Docente_Curso::where('id', $id)
        ->where('codDocente', $codDocente)
        ->where('idCurso', $idCurso)
        ->where('idperiodo', $idperiodo)
        ->first();

    // Realiza la eliminación del registro
    $docenteCurso->delete();

    return redirect()->route('docenteCurso.index')->with('datos', 'Registro eliminado con éxito.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
