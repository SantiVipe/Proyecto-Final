<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuario.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'identificacion'=> 'required|unique:usuarios',
            'nombre'=> 'required',
            'rol'=> 'required|in:admin,usuario',
            'password'=> 'required|min:8',
        ]);

        $usuario = new Usuario();
        $usuario->identificacion =$request->identificacion;
        $usuario->nombre = $request->nombre;
        $usuario->rol = $request->rol;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return redirect()->route('usuasrios.index')->with('success','Usuario creado exitosamente.');
    }

    public function edit(Usuario $usuario)
    {
        return view('usuario.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre'=>'required',
            'rol'=> 'required|in:admin,usuario',
            'password'=> 'nullable|min:8',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->rol = $request->rol;
        if ($request->filled('password')){
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();
        return redirect()->route('usuarios.index')->with('success','Usuario actualizado exitosamente.');
    }

    public function destroy( Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success','Usuario eliminado exitosamente.');
    }
}
