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

class ExamenController extends Controller
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

        $periodos = Periodo::all();
        $tiposCiclo = Tipo_Ciclo::all();
        $areas = Area::all();
        $aulas = Aula::all();
        $ciclos = Ciclo::all();
        $tiposExamen = Tipo_Examen::all();
        $idperiodoSeleccionado = session('periodoSeleccionado');
        return view('examen.index', compact('examenes', 'periodos', 'tiposCiclo', 'areas', 'ciclos', 'tiposExamen', 'idperiodoSeleccionado', 'aulas'));
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
        return view('examen.create', compact('periodos', 'tiposExamen', 'tiposCiclo', 'areas', 'ciclos', 'idperiodoSeleccionado', 'aulas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fecha' => 'required|date',
            'idaula' => 'required|exists:aula,idaula',
            'idtipoexamen' => 'required|exists:tipo_examen,idtipoexamen',
            'estado' => 'required|boolean'
        ]);

        Examen::create($request->all());
        return redirect()->route('examen.index');
    }

    public function edit($id)
    {
        $examen = Examen::findOrFail($id);
        $periodos = Periodo::all();
        $tiposExamen = Tipo_Examen::all();
        $tiposCiclo = Tipo_Ciclo::all();
        $areas = Area::all();
        $ciclos = Ciclo::all();
        $aulas = Aula::all();
        $idperiodoSeleccionado = session('periodoSeleccionado');
        return view('examen.edit', compact('examen', 'periodos', 'tiposExamen', 'tiposCiclo', 'areas', 'ciclos', 'idperiodoSeleccionado', 'aulas'));
    }

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
        return redirect()->route('examen.index');
    }

    public function destroy($id)
    {
        $examen = Examen::findOrFail($id);
        $examen->delete();
        return redirect()->route('examen.index');
    }

    public function confirmar($id)
    {
        $examen = Examen::findOrFail($id);
        return view('examen.confirmar', compact('examen'));
    }
}
