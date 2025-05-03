<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Ciclo;
use App\Models\Periodo;
use App\Models\Tipo_Examen;
use App\Models\Tipo_Ciclo;
use App\Models\Area;
use Illuminate\Http\Request;

class AulaController2 extends Controller
{
    public function index(Request $request)
    {
        
        $buscarpor = $request->get('buscarpor', '');
        $aulas = Aula::where('descripcion', 'like', "%$buscarpor%")
            ->with('ciclo') 
            ->paginate(10);
        return view('aula.index', compact('aulas', 'buscarpor'));
    }

    public function create()
    {
        $ciclos = Ciclo::all();

        $periodos = Periodo::all()->where('estado', '=', 1);
        $tiposExamen = Tipo_Examen::all();
        $tiposCiclo = Tipo_Ciclo::all();
        $areas = Area::all();
        $ciclos = Ciclo::all();
        $idperiodoSeleccionado = session('periodoSeleccionado');
        return view('aula.create', compact('ciclos','periodos', 'tiposExamen', 'tiposCiclo', 'areas', 'ciclos', 'idperiodoSeleccionado'));
    }

    public function store(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'descripcion' => 'required|string|max:255',
        'idciclo' => 'required|integer',
        'rutaHorario' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para el archivo
    ]);

    // Crear una nueva instancia del modelo Aula
    $aula = new Aula();
    $aula->descripcion = $request->descripcion;
    $aula->idciclo = $request->idciclo;
    $aula->estado = '1';

    if ($request->hasFile('rutaHorario')) {
        $file = $request->file('rutaHorario');
        $destinationPath = 'images/horarios/';
        $filename = time() . '-' . $file->getClientOriginalName();
        $uploadSuccess = $file->move($destinationPath, $filename);
        
        // Verificar si la foto se cargó correctamente antes de guardar la ruta en la base de datos
        if ($uploadSuccess) {
            $aula->rutaHorario = $destinationPath . $filename;
        }
    }

    // Guardar la instancia en la base de datos
    $aula->save();

    return redirect()->route('aula.index')->with('success', 'Aula creada exitosamente.');
}


    public function edit(Aula $aula)
    {
        $ciclos = Ciclo::all();
        $periodos = Periodo::all();
        $tiposExamen = Tipo_Examen::all();
        $tiposCiclo = Tipo_Ciclo::all();
        $areas = Area::all();
        $ciclos = Ciclo::all();
        $idperiodoSeleccionado = session('periodoSeleccionado');
        return view('aula.edit', compact('aula','ciclos','periodos', 'tiposExamen', 'tiposCiclo', 'areas', 'ciclos', 'idperiodoSeleccionado'));
    }

    public function update(Request $request, Aula $aula)
{
    // Validar los datos del formulario
    $request->validate([
        'descripcion' => 'required|string|max:255',
        'idciclo' => 'required|exists:ciclo,idciclo',
        'rutaHorario' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para el archivo
    ]);

    // Actualizar los campos del aula que no son el archivo de imagen
    $aula->descripcion = $request->descripcion;
    $aula->idciclo = $request->idciclo;
    $aula->estado = '1';

    // Procesar la imagen del comprobante si se proporciona
    if ($request->hasFile('rutaHorario')) {
        $file = $request->file('rutaHorario');
        $destinationPath = 'images/horarios/';
        $filename = time() . '-' . $file->getClientOriginalName();
        $uploadSuccess = $file->move($destinationPath, $filename);

        if ($uploadSuccess) {
            // Verificar si hay una imagen anterior y eliminarla
            if ($aula->rutaHorario) {
                $oldFilePath = public_path($aula->rutaHorario);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            // Actualizar la referencia de la imagen en la base de datos con la nueva ruta
            $aula->rutaHorario = $destinationPath . $filename;
        }
    }

    // Guardar los cambios en la base de datos
    $aula->save();

    return redirect()->route('aula.index')->with('datos', 'Aula actualizada con éxito.');
}


    public function confirmar(Aula $aula)
    {
        return view('aula.confirmar', compact('aula'));
    }

    public function destroy(Aula $aula)
    {
        $aula->delete();
        return redirect()->route('aula.index')->with('datos', 'Aula eliminada con éxito.');
    }


    public function getHorario($idaula)
{
    // Buscar el aula con el ID proporcionado
    $aula = Aula::find($idaula);
    // // Asegúrate de que `featured` contiene la ruta correcta.
    // $alumnos->each(function ($alumno) {
    //     $alumno->featured = asset($alumno->featured);
    // });
    // Verificar si el aula existe y si tiene una ruta de horario
    if ($aula && $aula->rutaHorario) {
        // Devolver la URL de la imagen en formato JSON
        return response()->json(['horario' => asset($aula->rutaHorario)]);
    } else {
        // Devolver un mensaje en caso de que no se encuentre el aula o la imagen
        return response()->json(['horario' => null]);
    }
}

}
