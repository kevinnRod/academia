<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Capacidad;
use Illuminate\Http\Request;
use App\Models\Nivel;
use Illuminate\Support\Facades\DB;

class CapacidadController extends Controller
{

    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $idperiodo = session('periodoSeleccionado');

        $capacidades = Capacidad::where('estado', '=', '1')
            ->where('descripcion', 'like', '%' . $buscarpor . '%')
            ->where('idperiodo', '=', $idperiodo)
            ->paginate($this::PAGINATION);

        return view('capacidades.index', compact('capacidades', 'buscarpor'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
{
    // Tu lógica para obtener datos y cargar la vista.
    $curso = Curso::where('estado', '=', '1')->get();
    $nivelEscolar = Nivel::all(); // Asegúrate de importar la clase NivelEscolar si no lo has hecho.

    // Pasa $request y $nivelEscolar a la vista.
    return view('capacidades.create', compact('curso', 'request', 'nivelEscolar'));
}


    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $idperiodo = session('periodoSeleccionado');

        $data = request()->validate([
            'idCurso' => 'required',
            'descripcion' => 'required|max:200',
        ]);
    
        $capacidad = new Capacidad();
        $capacidad->idCurso = $request->idCurso; 
        $capacidad->descripcion = $request->descripcion;
        $capacidad->estado = '1';
        $capacidad->idperiodo = $idperiodo;
        $capacidad->save();
    
        return redirect()->route('capacidades.index')->with('datos', 'Registro Nuevo Guardado..!');
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
    public function edit(Request $request, $idcapacidad)
{
    $curso = Curso::where('estado', '=', '1')->get();

    $capacidad = Capacidad::findOrFail($idcapacidad);
    $nivel = Nivel::all();
    return view('capacidades.edit', compact('curso', 'capacidad', 'nivel', 'request'));

}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $idcapacidad)
{
    $data = request()->validate([
        'idCurso' => 'required',
        'descripcion' => 'required|max:200',
    ],
    [
    ]);       

    $capacidad = Capacidad::findOrFail($idcapacidad);
    $capacidad->descripcion = $request->descripcion;
    $capacidad->idCurso = $request->idCurso; 
    $capacidad->estado = '1';

    $capacidad->save();
    return redirect()->route('capacidades.index')->with('datos', 'Capacidad editada..!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function confirmar(string $id)
    {
        $capacidad = Capacidad::findOrFail($id);
        return view('capacidades.confirmar', compact('capacidad'));
    }

    public function destroy($idcapacidad)
    {
        DB::delete('DELETE FROM capacidad WHERE idcapacidad = ?', [$idcapacidad]);
        return redirect()->route('capacidades.index')->with('datos', 'Registro Eliminado...!');
    }
}
