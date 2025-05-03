<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo_Ciclo;

class TipoCicloController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $tiposCiclo = Tipo_Ciclo::where('estado', '=', '1')
            ->where('descripcion', 'like', '%' . $buscarpor . '%')
            ->paginate($this::PAGINATION);

        return view('tipociclo.index', compact('tiposCiclo', 'buscarpor'));
    }

    public function create()
    {
        return view('tipociclo.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => 'required|unique:tipo_ciclo,descripcion',
        ], [
            'descripcion.required' => 'Ingrese la descripción del tipo de ciclo',
            'descripcion.unique' => 'La descripción ya está registrada',
        ]);

        $tipoCiclo = new Tipo_Ciclo();
        $tipoCiclo->descripcion = $request->descripcion;
        $tipoCiclo->estado = '1';
        $tipoCiclo->save();

        return redirect()->route('tipociclo.index')->with('datos', 'Nuevo Tipo de Ciclo creado...!');
    }

    public function edit($id)
    {
        $tipoCiclo = Tipo_Ciclo::findOrFail($id);
        return view('tipociclo.edit', compact('tipoCiclo'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'descripcion' => 'required|unique:tipo_ciclo,descripcion,' . $id . ',idtipociclo',
        ], [
            'descripcion.required' => 'Ingrese la descripción del tipo de ciclo',
            'descripcion.unique' => 'La descripción ya está registrada',
        ]);

        $tipoCiclo = Tipo_Ciclo::findOrFail($id);
        $tipoCiclo->descripcion = $request->descripcion;
        $tipoCiclo->save();

        return redirect()->route('tipociclo.index')->with('datos', 'Tipo de Ciclo actualizado...!');
    }

    public function confirmar($id)
    {
        $tipoCiclo = Tipo_Ciclo::findOrFail($id);
        return view('tipociclo.confirmar', compact('tipoCiclo'));
    }

    public function destroy($id)
    {
        $tipoCiclo = Tipo_Ciclo::findOrFail($id);
        $tipoCiclo->estado = '0';
        $tipoCiclo->save();

        return redirect()->route('tipociclo.index')->with('datos', 'Tipo de Ciclo eliminado...!');
    }
}
