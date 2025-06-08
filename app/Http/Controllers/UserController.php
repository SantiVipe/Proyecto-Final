<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Notifications\EnviarCredencialesEmpleado;

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

    public function show(User $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function store(Request $request)
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
                'direccion' => [
                    'required',
                    'string',
                    'max:255'
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
    
                'direccion.required' => 'La dirección es obligatoria.',
                'direccion.string' => 'La dirección debe ser una cadena de texto.',
                'direccion.max' => 'La dirección no puede tener más de 255 caracteres.'
            ]
        );
    
        $randomString = Str::random(4);
        $specialChars = ['!', '@', '#', '$', '%', '&', '*'];
        $randomChar = $specialChars[array_rand($specialChars)];
    
        $baseEmail = explode('@', $request->email)[0];
        $rawPassword = $baseEmail . $randomChar . $randomString;
    
        $usuario = new User();
        $usuario->cedula = $request->cedula;
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->direccion = $request->direccion;
        $usuario->rol = 'empleado';
        $usuario->password = Hash::make($rawPassword);
        $usuario->save();

        $usuario->notify(new EnviarCredencialesEmpleado($rawPassword));
    
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente. Contraseña generada: ' . $rawPassword);
    }    

    public function update(Request $request, User $usuario)
    {   //dd($usuario->id);
        $cedula_enviada= $request->input('cedula');
        $id_usuario_actual= $usuario->id;

        $existencia_cc=\DB::table('users')->where('cedula', $cedula_enviada)->first();
        $existencia_cc_ignorando= \DB::table('users')->where('cedula',$cedula_enviada)->where('id', '!=', $id_usuario_actual)->first();

        //dd([
        //    'cedula_enviada'=> $cedula_enviada,
        //    'id_usuario_actual'=> $id_usuario_actual,
        //    'cedula_usuario'=> $usuario->cedula,
        //    'existe'=> $existencia_cc ? true : false,
        //    'exite_ignorando'=>$existencia_cc_ignorando ? true : false,
        //    'cc_existente'=> $existencia_cc ? $existencia_cc->cedula : 'N/A',
        //    'cc_existente_ignorando'=>$existencia_cc_ignorando ? $existencia_cc_ignorando->cedula: 'N/A',
        //    'id_existente'=>$existencia_cc ? $existencia_cc->id : 'N/A',
        //   'id_existente_ignorando'=>$existencia_cc_ignorando ? $existencia_cc_ignorando->id : 'N/A',
        //]);
        $request->validate(
            [
                'nombre'=> [
                    'required',
                    'regex:/^[\pL\s]+$/u'
                ],
                'cedula'=> [
                    'required',
                    'numeric',
                    'digits_between:6,12',
                    Rule::unique('users', 'cedula')->ignore($usuario->id),
                ],

                'direccion'=>'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'regex:/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/',
                    Rule::unique('users', 'email')->ignore($usuario->id),
                ],
                'telefono' => [
                    'required',
                    'numeric',
                    'digits_between:7,10'
                ],
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.regex' => 'El nombre solo puede contener letras y espacios.',

                'cedula.required' => 'La cédula es obligatoria.',
                'cedula.unique' => 'La cédula ya está registrada.',
                'cedula.numeric' => 'La cédula solo puede contener números.',
                'cedula.digits_between' => 'La cédula debe tener entre 6 y 12 dígitos.',

                'direccion.required'=> 'La dirección es obligatoria.',
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El formato del correo no es válido.',
                'email.unique' => 'El correo electrónico ya está registrado.',
                'email.regex' => 'El correo debe ser del tipo usuario@dominio.com',

                'telefono.required' => 'El teléfono es obligatorio.',
                'telefono.numeric' => 'El teléfono solo puede contener números.',
                'telefono.digits_between' => 'El teléfono debe tener entre 7 y 10 dígitos.'
            ]
        );


        $usuario->nombre = $request->nombre;
        $usuario->cedula = $request->cedula;
        $usuario->direccion= $request->direccion;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success','Usuario eliminado exitosamente.');
    }
}