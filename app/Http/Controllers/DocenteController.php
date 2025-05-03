<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\EstadoCivil;
use App\Models\Nivel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocenteController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor=$request->get('buscarpor');
        $idperiodo = session('periodoSeleccionado');


        $docente = Docente::where('estado', '=', '1')
            ->where('apellidos','like','%'.$buscarpor.'%')
            ->paginate($this::PAGINATION);
        return view('docentes.index',compact('docente', 'buscarpor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estadosCivil=EstadoCivil::all();
        $niveles=Nivel::all();
        return view('docentes.create', compact('niveles', 'estadosCivil'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $idperiodo = session('periodoSeleccionado');

    // Validar los datos del formulario, incluida la imagen
    $data = request()->validate([
        'apellidos' => 'required',
        'nombres' => 'required',
        'direccion' => 'required',
        'telefono' => 'required',
        'idEstadoCivil' => 'required',
        'fechaIngreso' => 'required',
        'featured' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
    ],
    [
        'apellidos.required' => 'Ingrese apellidos del docente',
        'nombres.required' => 'Ingrese nombre del docente',
        'direccion.required' => 'Ingrese dirección del docente',
        'telefono.required' => 'Ingrese teléfono del docente',
        'idEstadoCivil.required' => 'Ingrese el estado civil del docente',
        'fechaIngreso.required' => 'Ingrese la fecha de ingreso del docente',
        'featured.required' => 'Seleccione una imagen',
        'featured.image' => 'El archivo debe ser una imagen',
        'featured.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg, gif o svg',
        'featured.max' => 'El tamaño máximo de la imagen es de 2MB',
    ]);
    if ($request->hasFile('featured')) {
        $file = $request->file('featured');
        $destinationPath = 'images/featureds/';
        $filename = time() . '-' . $file->getClientOriginalName();
        $uploadSuccess = $file->move($destinationPath, $filename);
        $data['featured'] = $destinationPath . $filename; // Guardar la ruta de la imagen

    }

    // Crear una instancia de Docente y guardar los datos en la base de datos
    $docente = new Docente($data);
    $docente->estado = '1';
    $docente->idnivel = '1';
    $docente->idperiodo = '2025-II';
    $docente->save();

    // Redireccionar al usuario a la página de índice de docentes con un mensaje de éxito
    return redirect()->route('docentes.index')->with('datos', 'Registro Nuevo Guardado...!');
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
        $docente=Docente::findOrFail($id);
        $niveles=Nivel::all();
        $estadosCivil=EstadoCivil::all();
        return view('docentes.edit',compact('docente', 'niveles', 'estadosCivil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos del formulario
        $data = $request->validate([
            'apellidos' => 'required',
            'nombres' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'featured' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validar la imagen
        ], [
            'apellidos.required' => 'Ingrese apellidos del docente',
            'nombres.required' => 'Ingrese nombre del docente',
            'direccion.required' => 'Ingrese dirección del docente',
            'telefono.required' => 'Ingrese teléfono del docente',
            'featured.image' => 'El archivo debe ser una imagen',
            'featured.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg, gif o svg',
            'featured.max' => 'El tamaño máximo de la imagen es de 2MB',
        ]);
    
        // Encontrar al docente por su ID
        $docente = Docente::findOrFail($id);
    
        // Asignar los nuevos valores a las propiedades del docente
        $docente->apellidos = $request->apellidos;
        $docente->nombres = $request->nombres;
        $docente->direccion = $request->direccion;
        $docente->idEstadoCivil = $request->idEstadoCivil; // Asegúrate de que esta propiedad exista en tu modelo Docente
        $docente->telefono = $request->telefono;
        $docente->fechaIngreso = $request->fechaIngreso;
        $docente->idNivel = $request->idNivel; // Asegúrate de que esta propiedad exista en tu modelo Docente
    
        // Procesar la nueva imagen si se proporciona
        if ($request->hasFile('featured')) {
            $file = $request->file('featured');
            $destinationPath = 'images/featureds/';
            $filename = time() . '-' . $file->getClientOriginalName();
            $uploadSuccess = $file->move($destinationPath, $filename);
            if ($uploadSuccess) {
                // Verificar si hay una imagen anterior y eliminarla
                if ($docente->featured) {
                    $oldFilePath = public_path($docente->featured);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                // Actualizar la referencia de la imagen en la base de datos con la nueva ruta
                $docente->featured = $destinationPath . $filename;
            }
        }

    
        // Guardar los cambios en la base de datos
        $docente->save();
        
        // Redireccionar al usuario a la página de índice de docentes con un mensaje de éxito
        return redirect()->route('docentes.index')->with('datos', 'Registro Actualizado...!');
    }
    

    /**
     * Remove the specified resource from storage.
     */

    public function confirmar($id)
    {
        $docente=Docente::findOrFail($id);
        return view('docentes.confirmar',compact('docente'));
    }
    
    public function destroy(string $id)
    {
        $docente=Docente::findOrFail($id);
        $docente->estado='0';
        $docente->save();

        return redirect()->route('docentes.index')->with('datos','Registro Eliminado...!');
    }
}
