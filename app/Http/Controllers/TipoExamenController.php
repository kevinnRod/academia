<?php

namespace App\Http\Controllers;

use App\Models\Tipo_Examen;
use Illuminate\Http\Request;

class TipoExamenController extends Controller
{
    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $tipoexamenes = Tipo_Examen::where('descripcion', 'like', '%' . $buscarpor . '%')
            ->paginate(10);
        return view('tipoexamen.index', compact('tipoexamenes', 'buscarpor'));
    }

    public function create()
    {
        return view('tipoexamen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|max:255',
            'estado' => 'required|boolean',
        ]);

        $tipoexamen = new Tipo_Examen();
        $tipoexamen->descripcion = $request->descripcion;
        $tipoexamen->estado = $request->estado;
        $tipoexamen->save();

        return redirect()->route('tipoexamen.index')->with('datos', 'Examen registrado correctamente.');
    }

    public function edit($id)
    {
        $tipoexamen = Tipo_Examen::findOrFail($id);
        return view('tipoexamen.edit', compact('tipoexamen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|max:255',
            'estado' => 'required|boolean',
        ]);

        $tipoexamen = Tipo_Examen::findOrFail($id);
        $tipoexamen->descripcion = $request->descripcion;
        $tipoexamen->estado = $request->estado;
        $tipoexamen->save();

        return redirect()->route('tipoexamen.index')->with('datos', 'Examen actualizado correctamente.');
    }

    public function confirmar($id)
    {
        $tipoexamen = Tipo_Examen::findOrFail($id);
        return view('tipoexamen.confirmar', compact('tipoexamen'));
    }

    public function destroy($id)
    {
        $tipoexamen = Tipo_Examen::findOrFail($id);
        $tipoexamen->delete();

        return redirect()->route('tipoexamen.index')->with('datos', 'Examen eliminado correctamente.');
    }
}
