<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Nivel;
use Illuminate\Http\Request;

class CursoController extends Controller
{

    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $idperiodo = session('periodoSeleccionado');

        $cursos = Curso::where('estado', '=', '1')
            ->where('curso', 'like', '%' . $buscarpor . '%')
            ->where('idperiodo', '=', $idperiodo)
            ->paginate($this::PAGINATION);

        return view('cursos.index', compact('cursos', 'buscarpor'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nivelEscolar = Nivel::all();
        return view('cursos.create', compact('nivelEscolar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $idperiodo = session('periodoSeleccionado');
        $data = request()->validate([
            'codCurso' => 'required',
            'curso' => 'required'
        ],
        [
            'codCurso.required'=>'Ingrese una sección',
            'curso.required'=>'Ingrese aula'
        ]);
        
        $existe = Curso::where('estado','=','1')->where('codCurso','=',$request->codCurso)->where('idNivel','=',$request->idNivel)->first();

        if($existe == null)
        {
            $curso = new Curso();
            $curso->codCurso = $request->codCurso;
            $curso->curso = $request->curso;
            $curso->idNivel = $request->idNivel;
            $curso->estado='1';
            $curso->idperiodo = $idperiodo;
        }
        else
        {
            request()->validate([
                'codCurso' => 'unique:cursos,codCurso'
            ],
            [
                'codCurso.unique'=>'Código existente'
            ]);
        }
        $curso->save();
        return redirect()->route('cursos.index')->with('datos','Nueva sección creada...!');
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
        $curso = Curso::findOrFail($id);
        $nivelEscolar = Nivel::all();
        return view('cursos.edit', compact('curso', 'nivelEscolar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = request()->validate([
            'codCurso' => 'required',
            'curso' => 'required'
        ],
        [
            'codCurso.required'=>'Ingrese una sección',
            'curso.required'=>'Ingrese aula'
        ]);

        $curso = Curso::findOrFail($id);
        
        if($curso->codCurso == $request->codCurso and $curso->idNivel == $request->idNivel)
        {
            $curso->curso = $request->curso;
        }
        else
        {
            $existe = Curso::where('estado','=','1')->where('codCurso','=',$request->codCurso)->where('idNivel','=',$request->idNivel)->first();
            if($existe == null)
            {
                $curso->codCurso = $request->codCurso;
                $curso->curso = $request->curso;
                $curso->idNivel = $request->idNivel;
            }
            else
            {
                request()->validate([
                    'codCurso' => 'unique:cursos,codCurso'
                ],
                [
                    'codCurso.unique'=>'Código existente'
                ]);
            }
        }
        
        $curso->save();
        return redirect()->route('cursos.index')->with('datos','Cuarso editado...!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function confirmar(string $id)
    {
        $curso = Curso::findOrFail($id);
        return view('cursos.confirmar', compact('curso'));
    }

    public function destroy(string $id)
    {
        $curso = Curso::findOrFail($id);
        $curso->estado='0';
        $curso->save();

        return redirect()->route('cursos.index')->with('datos','Registro Eliminado...!');
    }
}
