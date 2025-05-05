<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\EstadoCivil;
use App\Models\Nivel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\Models\SharedAccessBlobPermissions;
use MicrosoftAzure\Storage\Common\Models\SharedAccessSignatureHelper;

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
        $niveles=Nivel::all();
        return view('docentes.create', compact('niveles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $idperiodo = session('periodoSeleccionado');
    
        $data = $request->validate([
            'apellidos' => 'required',
            'nombres' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'fechaIngreso' => 'required',
            'featured' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'apellidos.required' => 'Ingrese apellidos del docente',
            'nombres.required' => 'Ingrese nombre del docente',
            'direccion.required' => 'Ingrese dirección del docente',
            'telefono.required' => 'Ingrese teléfono del docente',
            'fechaIngreso.required' => 'Ingrese la fecha de ingreso del docente',
            'featured.required' => 'Seleccione una imagen',
            'featured.image' => 'El archivo debe ser una imagen',
            'featured.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg, gif o svg',
            'featured.max' => 'El tamaño máximo de la imagen es de 2MB',
        ]);
    
        if ($request->hasFile('featured')) {
            $file = $request->file('featured');
            $filename = time() . '-' . $file->getClientOriginalName();
            $ruta = 'docentes/' . $filename;
    
            // Subir a Azure Blob Storage (contenedor privado)
            Storage::disk('azure')->put($ruta, fopen($file, 'r+'));
    
            // Guardar solo la ruta relativa (NO la URL completa)
            $data['featured'] = $ruta;
        }
    
        $docente = new Docente($data);
        $docente->estado = '1';
        $docente->idnivel = '1';
        $docente->idperiodo = '2025-II';
        $docente->save();
    
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
        return view('docentes.edit',compact('docente', 'niveles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'apellidos' => 'required',
            'nombres' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'fechaIngreso' => 'required',
            'idNivel' => 'required',
            'featured' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'apellidos.required' => 'Ingrese apellidos del docente',
            'nombres.required' => 'Ingrese nombre del docente',
            'direccion.required' => 'Ingrese dirección del docente',
            'telefono.required' => 'Ingrese teléfono del docente',
            'fechaIngreso.required' => 'Ingrese la fecha de ingreso del docente',
            'idNivel.required' => 'Seleccione el nivel',
            'featured.image' => 'El archivo debe ser una imagen',
            'featured.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg, gif o svg',
            'featured.max' => 'El tamaño máximo de la imagen es de 2MB',
        ]);

        $docente = Docente::findOrFail($id);

        // Actualizar atributos
        $docente->fill($data);

        // Procesar nueva imagen
        if ($request->hasFile('featured')) {
            $file = $request->file('featured');
            $filename = time() . '-' . $file->getClientOriginalName();
            $ruta = 'docentes/' . $filename;

            // Eliminar la imagen anterior si existe
            if ($docente->featured && Storage::disk('azure')->exists($docente->featured)) {
                Storage::disk('azure')->delete($docente->featured);
            }

            // Subir nueva imagen
            Storage::disk('azure')->put($ruta, fopen($file, 'r+'));

            // Guardar solo la ruta relativa
            $docente->featured = $ruta;
        }

        $docente->save();

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
