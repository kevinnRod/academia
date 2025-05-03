<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursoo;

class CursooController extends Controller
{
    // Método para mostrar la lista de cursos
    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $cursos = Cursoo::where('descripcion', 'LIKE', "%$buscarpor%")->paginate(10);
        return view('cursoos.index', compact('cursos', 'buscarpor'));
    }


    // Método para mostrar el formulario de creación
    public function create()
    {
        return view('cursoos.create');
    }

    // Método para almacenar un nuevo curso
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|boolean',
        ]);

        Cursoo::create($request->all());

        return redirect()->route('cursoos.index')->with('success', 'Curso creado exitosamente.');
    }

    // Método para mostrar el formulario de edición
    public function edit($idcurso)
    {
        $curso = Cursoo::findOrFail($idcurso);
        return view('cursoos.edit', compact('curso'));
    }

    // Método para actualizar un curso existente
    public function update(Request $request, $idcurso)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|boolean',
        ]);

        $curso = Cursoo::findOrFail($idcurso);
        $curso->update($request->all());

        return redirect()->route('cursoos.index')->with('success', 'Curso actualizado exitosamente.');
    }

    public function confirmar($id)
    {
        $curso = Cursoo::findOrFail($id);
        return view('cursoos.confirmar', compact('curso'));
    }

    // Método para confirmar la eliminación de un curso
    public function destroy($idcurso)
    {
        $curso = Cursoo::findOrFail($idcurso);
        $curso->delete();

        return redirect()->route('cursoos.index')->with('success', 'Curso eliminado exitosamente.');
    }
}
