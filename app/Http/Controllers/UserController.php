<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class UserController extends Controller
{

    public function showLogin()
    {
        return view('login');
    }

    public function verificalogin(Request $request)
    {
        //return dd($request->all());
        $data=request()->validate([
            'name'=>'required',
            'password'=>'required'
        ],
        [
            'name.required'=>'Ingrese Usuario',
            'password.required'=>'Ingrese contraseña',
        ]);

        if (Auth::attempt($data))
        {
            $con='OK';
        }

        $name=$request->get('name');
        $query=User::where('name','=',$name)->get();

        if ($query->count()!=0)
        {
            $hashp=$query[0]->password;
            $password=$request->get('password');
            if (password_verify($password, $hashp))
            {
                return redirect()->route('seleccionar-periodo');
            }
            else
            {
                return back()->withErrors(['password'=>'Contraseña no válida'])->withInput(request(['name', 'password']));
            }
        }
        else
        {
            return back()->withErrors(['name'=>'Usuario no válido'])->withInput(request(['name']));
        }
    } 

    public function salir()
    {
        Auth::logout();
        return redirect('/');
    }
       

}
