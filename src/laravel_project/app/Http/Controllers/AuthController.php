<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellido_paterno' => ['required', 'string', 'max:100'],
            'apellido_materno' => ['required', 'string', 'max:100'],
            'numero_cuenta' => ['required', 'string', 'max:50', 'unique:alumnos,numero_cuenta'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $alumno = Alumno::create([
            'nombre' => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'],
            'numero_cuenta' => $data['numero_cuenta'],
            'rol' => 'alumno',
            'password' => Hash::make($data['password']),
        ]);

        Auth::guard('alumno')->login($alumno);

        return redirect()->route('dashboard');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'numero_cuenta' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $ok = Auth::guard('alumno')->attempt([
            'numero_cuenta' => $credentials['numero_cuenta'],
            'password' => $credentials['password'],
            'rol' => 'alumno',
        ], $request->boolean('remember'));

        if (!$ok) {
            return back()
                ->withErrors(['numero_cuenta' => 'Credenciales inválidas o no eres alumno.'])
                ->onlyInput('numero_cuenta');
        }

        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('alumno')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
