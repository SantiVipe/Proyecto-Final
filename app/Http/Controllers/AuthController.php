<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'identificacion' => 'required|string|unique:users,identificacion',
            'nombre'         => 'required|string|max:255',
            'rol'            => 'required|in:admin,cliente', // Validación de enum
            'direccion'      => 'nullable|string|max:255',
            'telefono'       => 'nullable|string|max:20',
            'password'       => 'required|string|confirmed|min:6',
        ]);

        $user = User::create([
            'identificacion' => $request->identificacion,
            'nombre'         => $request->nombre,
            'rol'            => $request->rol,
            'direccion'      => $request->direccion,
            'telefono'       => $request->telefono,
            'password'       => $request->password, // Se hashea automáticamente por el cast
        ]);

        Auth::login($user);

        return redirect('/home');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identificacion' => 'required|string',
            'password'       => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'identificacion' => 'Las credenciales no son correctas.',
        ]);
    }
}
