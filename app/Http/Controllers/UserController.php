<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cedula'=> 'required|unique:users',
            'nombre'=> 'required',
            'rol'=> 'required|in:admin,usuario',
            'email' => 'required|email|unique:users',
            'password'=> 'required|min:8',
        ]);

        $usuario = new User();
        $usuario->cedula = $request->cedula;
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return redirect()->route('usuarios.index')->with('success','Usuario creado exitosamente.');
    }

    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nombre'=>'required',
            'rol'=> 'required|in:admin,usuario',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password'=> 'nullable|min:8',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->rol = $request->rol;
        $usuario->email = $request->email;

        if ($request->filled('password')){
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();
        return redirect()->route('usuarios.index')->with('success','Usuario actualizado exitosamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success','Usuario eliminado exitosamente.');
    }
}
