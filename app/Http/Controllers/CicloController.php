<?php

namespace App\Http\Controllers;

use App\Models\Ciclo;
use App\Models\Tipo_Ciclo;
use App\Models\Periodo;
use App\Models\Area;
use Illuminate\Http\Request;

class CicloController extends Controller
{
    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor', '');
        $ciclos = Ciclo::where('descripcion', 'like', "%$buscarpor%")
            ->with(['tipo_ciclo', 'periodo', 'area'])
            ->paginate(10);
        return view('ciclo.index', compact('ciclos', 'buscarpor'));
    }

    public function create()
    {
        $tiposCiclo = Tipo_Ciclo::where('estado', 1)->get();
        $periodos = Periodo::where('estado', 1)->get();
        $areas = Area::where('estado', 1)->get();
        return view('ciclo.create', compact('tiposCiclo', 'periodos', 'areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fechaInicio' => 'required|date',
            'fechaTermino' => 'required|date|after_or_equal:fechaInicio',
            'idtipociclo' => 'required|exists:tipo_ciclo,idtipociclo',
            'idperiodo' => 'required|exists:periodo,idperiodo|string|max:10',
            'idarea' => 'required|exists:area,idarea',
        ]);

        $cicloData = $request->all();
        $cicloData['estado'] = $cicloData['estado'] ?? 1; // Set default value for estado

        Ciclo::create($cicloData);
        return redirect()->route('ciclo.index')->with('datos', 'Ciclo creado con éxito.');
    }

    public function edit(Ciclo $ciclo)
    {
        $tiposCiclo = Tipo_Ciclo::where('estado', 1)->get();
        $periodos = Periodo::where('estado', 1)->get();
        $areas = Area::where('estado', 1)->get();
        return view('ciclo.edit', compact('ciclo', 'tiposCiclo', 'periodos', 'areas'));
    }

    public function update(Request $request, Ciclo $ciclo)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fechaInicio' => 'required|date',
            'fechaTermino' => 'required|date|after_or_equal:fechaInicio',
            'idtipociclo' => 'required|exists:tipo_ciclo,idtipociclo',
            'idperiodo' => 'required|exists:periodo,idperiodo',
            'idarea' => 'required|exists:area,idarea',
        ]);

        $cicloData = $request->all();
        $cicloData['estado'] = $cicloData['estado'] ?? 1; // Set default value for estado

        $ciclo->update($cicloData);
        return redirect()->route('ciclo.index')->with('datos', 'Ciclo actualizado con éxito.');
    }

    public function confirmar(Ciclo $ciclo)
    {
        return view('ciclo.confirmar', compact('ciclo'));
    }

    public function destroy(Ciclo $ciclo)
    {
        $ciclo->delete();
        return redirect()->route('ciclo.index')->with('datos', 'Ciclo eliminado con éxito.');
    }
}
