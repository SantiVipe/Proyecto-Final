<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
            'nombre'=> [
                'required',
                'regex:/^[\pL\s]+$/u'
            ],
            'cedula'=> [
                'required',
                'unique:users',
                'numeric',
                'digits_between:6,12'
            ],
            'email' => [
                'required',
                'email',
                'unique:users',
                'regex:/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/'
            ],
            'telefono' => [
                'required',
                'numeric',
                'digits_between:7,10'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ]
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',

            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.unique' => 'La cédula ya está registrada.',
            'cedula.numeric' => 'La cédula solo puede contener números.',
            'cedula.digits_between' => 'La cédula debe tener entre 6 y 12 dígitos.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'email.regex' => 'El correo debe ser del tipo usuario@dominio.com',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.numeric' => 'El teléfono solo puede contener números.',
            'telefono.digits_between' => 'El teléfono debe tener entre 7 y 10 dígitos.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener letras, números y al menos un símbolo (como !, @, #, etc.).'
        ]);

        $usuario = new User();
        $usuario->nombre = $request->nombre;
        $usuario->cedula = $request->cedula;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate(
            [
                'nombre'=> [
                    'required',
                    'regex:/^[\pL\s]+$/u'
                ],
                'cedula'=> [
                    'required',
                    'unique:users',
                    'numeric',
                    'digits_between:6,12',
                    Rule::unique('users')->ignore($usuarios->id),
                ],
                'email' => [
                    'required',
                    'email',
                    'unique:users',
                    'regex:/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/',
                    Rule::unique('users')->ignore($usuarios->id),
                ],
                'telefono' => [
                    'required',
                    'numeric',
                    'digits_between:7,10'
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%&*]).+$/'
                ]
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.regex' => 'El nombre solo puede contener letras y espacios.',

                'cedula.required' => 'La cédula es obligatoria.',
                'cedula.unique' => 'La cédula ya está registrada.',
                'cedula.numeric' => 'La cédula solo puede contener números.',
                'cedula.digits_between' => 'La cédula debe tener entre 6 y 12 dígitos.',

                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El formato del correo no es válido.',
                'email.unique' => 'El correo electrónico ya está registrado.',
                'email.regex' => 'El correo debe ser del tipo usuario@dominio.com',

                'telefono.required' => 'El teléfono es obligatorio.',
                'telefono.numeric' => 'El teléfono solo puede contener números.',
                'telefono.digits_between' => 'El teléfono debe tener entre 7 y 10 dígitos.',

                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.regex' => 'La contraseña debe contener letras, números y al menos un carácter especial (!@#$%&*).'
            ]
        );

        $usuario->nombre = $request->nombre;
        $usuario->cedula = $request->cedula;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success','Usuario eliminado exitosamente.');
    }
}
