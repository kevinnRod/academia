<?php

namespace App\Http\Controllers;

use App\Models\Catedra;
use App\Models\Cursoo;
use App\Models\Docente;
use App\Models\Aula;
use App\Models\Periodo;
use App\Models\Tipo_Ciclo;
use App\Models\Area;
use App\Models\Ciclo;
use Illuminate\Http\Request;

class CatedraController extends Controller
{
    // Método para mostrar la lista de cátedras
    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $catedras = Catedra::whereHas('curso', function ($query) use ($buscarpor) {
            $query->where('descripcion', 'like', "%$buscarpor%");
        })->paginate(10);

        return view('catedra.index', compact('catedras', 'buscarpor'));
    }

    // Método para mostrar el formulario de creación de una nueva cátedra
    public function create()
    {
        $docentes = Docente::where('estado', '1')->get();
        $cursos = Cursoo::where('estado', '1')->get();
        $periodos = Periodo::all();
        $tiposCiclo = Tipo_Ciclo::all();
        $areas = Area::all();
        $idperiodoSeleccionado = session('periodoSeleccionado', '');

        return view('catedra.create', compact('docentes', 'cursos', 'periodos', 'tiposCiclo', 'areas', 'idperiodoSeleccionado'));
    }


    // Método para almacenar una nueva cátedra
    public function store(Request $request)
    {
        $request->validate([
            'codDocente' => 'required',
            'idcurso' => 'required',
            'idaula' => 'required',
            'estado' => 'required'
        ]);

        Catedra::create($request->all());

        return redirect()->route('catedra.index')->with('datos', 'Cátedra creada correctamente!');
    }

    // Método para mostrar el formulario de edición de una cátedra
    public function edit($id)
    {
        $catedra = Catedra::findOrFail($id);
        $docentes = Docente::where('estado', '1')->get();
        $cursos = Cursoo::where('estado', '1')->get();
        $periodos = Periodo::all();
        $tiposCiclo = Tipo_Ciclo::all();
        $areas = Area::all();
        $ciclos = Ciclo::all();
        $aulas = Aula::all();
        $idperiodoSeleccionado = $catedra->idperiodo;
        
        return view('catedra.edit', compact('catedra', 'docentes', 'cursos', 'periodos', 'tiposCiclo', 'areas', 'idperiodoSeleccionado', 'ciclos', 'aulas'));
    }


    // Método para actualizar una cátedra
    public function update(Request $request, $id)
    {
        $request->validate([
            'codDocente' => 'required',
            'idcurso' => 'required',
            'idaula' => 'required',
            'estado' => 'required'
        ]);

        $catedra = Catedra::findOrFail($id);

        $catedra->codDocente = $request->codDocente;
        $catedra->idcurso = $request->idcurso;
        $catedra->idaula = $request->idaula;
        $catedra->estado = $request->estado;
        $catedra->save();

        return redirect()->route('catedra.index')->with('datos', 'Cátedra actualizada correctamente!');
    }

    // Método para confirmar la eliminación de una cátedra
    public function confirmar($id)
    {
        $catedra = Catedra::findOrFail($id);

        return view('catedra.confirmar', compact('catedra'));
    }

    // Método para eliminar una cátedra
    public function destroy($id)
    {
        $catedra = Catedra::findOrFail($id);
        $catedra->delete();

        return redirect()->route('catedra.index')->with('datos', 'Cátedra eliminada correctamente!');
    }
}
