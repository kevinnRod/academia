<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periodo;
class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index()
    // {
    //     return view('bienvenido');
    // }
    public function index($periodo = null)
{
    // Si se proporciona un período en la ruta, úsalo
    // De lo contrario, verifica si el período está en la sesión

    $periodoSeleccionado = session()->get('periodoSeleccionado');
    

    // Retorna la vista 'bienvenido' con el valor del período seleccionado
    return view('bienvenido', compact('periodoSeleccionado'));
}
public function procesarSeleccionPeriodo(Request $request)
{
    $request->validate([
        'periodo' => 'required',
    ]);

    $periodoSeleccionado = $request->input('periodo');

    // $request->session()->flash('periodoSeleccionado', $periodoSeleccionado);
    session()->put('periodoSeleccionado', $periodoSeleccionado);
    $periodoSeleccionado = session()->get('periodoSeleccionado');

    // Redirige al usuario a la página principal (/home) con el período seleccionado como parte de la URL
    return redirect()->route('home', ['periodo' => $periodoSeleccionado])->with('success', 'Período seleccionado correctamente');
}
    
    public function seleccionarPeriodo()
    {
        $periodos = Periodo::where('estado', 1)->get();
        return view('select_period', ['periodos' => $periodos]);
    }
}
