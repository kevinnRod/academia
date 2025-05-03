<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use App\Models\Grado;
use App\Models\Nivel;
use App\Models\Seccion;
use Illuminate\Http\Request;

class AulaController extends Controller
{

    const PAGINATION = 10;

    public function index($idperiodo)
    {
        $periodo = Periodo::findOrFail($idperiodo);
        $secciones = Seccion::where('idperiodo','=', $idperiodo)->where('estado','=','1')->paginate($this::PAGINATION);;
        return view('aulas.index',compact('secciones', 'periodo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idperiodo)
    {
        $periodo = Periodo::findOrFail($idperiodo);
        $nivelEscolar = Nivel::all();
        $grados = Grado::all();

        return view('aulas.create', compact('grados','periodo', 'nivelEscolar'));

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($idperiodo, Request $request)
    {
        $data = request()->validate([
            'idNivel' => 'required',
            'idGrado' => 'required',
            'seccion' => 'required',
            'aula' => 'required'
        ],
        [
            'idNivel.required'=>'Seleccione Nivel Escolar',
            'idGrado.required'=>'Seleccione el Grado Escolar',
            'seccion.required'=>'Ingrese una sección',
            'aula.required'=>'Ingrese aula'
        ]);

        $existe = Seccion::where('idperiodo','=', $idperiodo)->where('estado','=','1')->where('idGrado','=',$request->idGrado)->where('seccion','=',$request->seccion)->first();
        if($existe == null)
        {
            $seccion = new Seccion();
            $seccion->idGrado = $request->idGrado;
            $seccion->idperiodo = $idperiodo;
            $seccion->seccion = $request->seccion;
            $seccion->aula = $request->aula;
            $seccion->estado='1';
        }
        else
        {
            request()->validate([
                'seccion' => 'required|unique:secciones,seccion'
            ],
            [
                'seccion.required'=>'Ingrese una sección',
                'seccion.unique'=>'Seccion ya existente'
            ]);
        }
        $seccion->save();
        return redirect()->route('aulas.index', $idperiodo)->with('datos','Nueva sección creada...!');
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
        $seccion = Seccion::findOrFail($id);
        $grados = Grado::all();
        $nivelEscolar = Nivel::all();
        return view('aulas.edit', compact('seccion', 'grados', 'nivelEscolar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idA, string $idS)
    {
        $data = request()->validate([
            'idNivel' => 'required',
            'idGrado' => 'required',
            'seccion' => 'required',
            'aula' => 'required'
        ],
        [
            'idNivel.required'=>'Seleccione Nivel Escolar',
            'idGrado.required'=>'Seleccione el Grado Escolar',
            'seccion.required'=>'Ingrese una sección',
            'aula.required'=>'Ingrese aula'
        ]);

        $seccion = Seccion::findOrFail($idS);

        if($seccion->idGrado == $request->idGrado and $seccion->seccion == $request->seccion)
        {   
            $seccion->aula = $request->aula;
        }
        else
        {
            $existe = Seccion::where('idperiodo','=', $idA)->where('estado','=','1')->where('idGrado','=',$request->idGrado)->where('seccion','=',$request->seccion)->first();
            if($existe == null)
            {
                $seccion->idGrado = $request->idGrado;
                $seccion->seccion = $request->seccion;
                $seccion->aula = $request->aula;
            }
            else
            {
                request()->validate([
                    'seccion' => 'required|unique:secciones,seccion'
                ],
                [
                    'seccion.required'=>'Ingrese una sección',
                    'seccion.unique'=>'Seccion ya exitente'
                ]);
            }
        }
        $seccion->save();
        return redirect()->route('aulas.index', $seccion->idperiodo)->with('datos','Nueva sección creada...!');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function confirmar($id)
    {
        $seccion = Seccion::findOrFail($id);
        return view('aulas.confirmar', compact('seccion'));
    }

    public function destroy(string $idS)
    {
        $seccion=Seccion::findOrFail($idS);
        $seccion->estado='0';
        $seccion->save();

        return redirect()->route('aulas.index', $seccion->idperiodo)->with('datos','Registro Eliminado...!');
    }

    public function cancelar($idAnyo)
    {
        return redirect()->route('aulas.index', $idAnyo)->with('datos','Acción Cancelada ..!');
    }
}
