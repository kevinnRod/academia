<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $areas = Area::where('estado', '=', '1')
            ->where('descripcion', 'like', '%' . $buscarpor . '%')
            ->paginate($this::PAGINATION);
        
        return view('area.index', compact('areas', 'buscarpor'));
    }

    public function create()
    {
        return view('area.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => 'required|unique:area,descripcion',
        ], [
            'descripcion.required' => 'Ingrese la descripción del área',
            'descripcion.unique' => 'La descripción ya está registrada',
        ]);

        $area = new Area();
        $area->descripcion = $request->descripcion;
        $area->estado = '1';
        $area->save();

        return redirect()->route('area.index')->with('datos', 'Nueva Área creada...!');
    }

    public function edit($id)
    {
        $area = Area::findOrFail($id);
        return view('area.edit', compact('area'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'descripcion' => 'required|unique:area,descripcion,' . $id . ',idarea',
        ], [
            'descripcion.required' => 'Ingrese la descripción del área',
            'descripcion.unique' => 'La descripción ya está registrada',
        ]);

        $area = Area::findOrFail($id);
        $area->descripcion = $request->descripcion;
        $area->save();

        return redirect()->route('area.index')->with('datos', 'Área actualizada...!');
    }

    public function confirmar($id)
    {
        $area = Area::findOrFail($id);
        return view('area.confirmar', compact('area'));
    }

    public function destroy($id)
    {
        $area = Area::findOrFail($id);
        $area->estado = '0';
        $area->save();

        return redirect()->route('area.index')->with('datos', 'Área eliminada...!');
    }
}
