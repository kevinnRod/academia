<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Area;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor', '');
        $carreras = Carrera::where('descripcion', 'like', "%$buscarpor%")
            ->with('area') 
            ->paginate(10);

        return view('carrera.index', compact('carreras', 'buscarpor'));
    }

    public function create()
    {
        $areas = Area::where('estado', 1)->get();
        return view('carrera.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'idarea' => 'required|exists:area,idarea',
        ]);

        Carrera::create($request->all());
        return redirect()->route('carrera.index')->with('datos', 'Carrera creada con éxito.');
    }

    public function edit(Carrera $carrera)
    {
        $areas = Area::where('estado', 1)->get();
        return view('carrera.edit', compact('carrera', 'areas'));
    }

    public function update(Request $request, Carrera $carrera)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'idarea' => 'required|exists:area,idarea',
        ]);

        $carrera->update($request->all());
        return redirect()->route('carrera.index')->with('datos', 'Carrera actualizada con éxito.');
    }

    public function confirmar(Carrera $carrera)
    {
        return view('carrera.confirmar', compact('carrera'));
    }

    public function destroy(Carrera $carrera)
    {
        $carrera->delete();
        return redirect()->route('carrera.index')->with('datos', 'Carrera eliminada con éxito.');
    }
}
