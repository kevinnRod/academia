<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\Request;

class AnyoEscolarController extends Controller
{

    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor=$request->get('buscarpor');

        $periodo=Periodo::where('estado','=','1')->where('idperiodo','like','%'.$buscarpor.'%')->paginate($this::PAGINATION);;
        return view('periodo.index',compact('periodo', 'buscarpor'));
    }

    

    public function general(Request $request)
    {
        $idperiodo = session('periodoSeleccionado');

        $periodo = Periodo::where('estado', '1')
            ->where('idperiodo', '=', $idperiodo)
            ->paginate($this::PAGINATION);

        // Definir un arreglo de nombres de archivo de imágenes (ajusta las rutas según tu proyecto)
        $imagenes = [
            'virup.jpg',
            'card2.jpg',
            'card3.jpeg',
            'card4.jpg',
        ];

        return view('aulas.general', compact('periodo', 'imagenes'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('periodo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'idperiodo'=>'required|unique:periodo,idperiodo'
        ],
        [
            'idperiodo.required'=>'Ingrese año del periodo escolar',
            'idperiodo.unique'=>'Año escolar ya registrado'
        ]);

        $periodo = new Periodo();
        $periodo->idperiodo = $request->idperiodo;
        $periodo->fechaInicio = $request->fechaInicio;
        $periodo->fechaTermino = $request->fechaTermino;
        $periodo->estado='1';
        $periodo->save();
        return redirect()->route('periodo.index')->with('datos','Nuevo Año escolar creado...!');
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
    public function edit(string $id)
    {
        $periodo=Periodo::findOrFail($id);
        return view('periodo.edit',compact('periodo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $periodo = Periodo::findOrFail($id);
        $periodo->idperiodo = $request->idperiodo;

        $periodo->fechaInicio = $request->fechaInicio;
        $periodo->fechaTermino = $request->fechaTermino;
        $periodo->save();

        return redirect()->route('periodo.index')->with('datos','Año escolar actualizado...!');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function confirmar($id)
    {
        $periodo=Periodo::findOrFail($id);
        return view('periodo.confirmar',compact('periodo'));
    }

    public function destroy(string $id)
    {
        $periodo=Periodo::findOrFail($id);
        $periodo->estado='0';
        $periodo->save();

        return redirect()->route('periodo.index')->with('datos','Registro Eliminado...!');
    }
}
