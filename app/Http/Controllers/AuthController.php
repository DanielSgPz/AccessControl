<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Superuser;

class AuthController extends Controller
{
     // Show login form
     public function showLoginForm()
     {
         return view('auth.login');

     }

      // Login management
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            // Verificar si el usuario es superusuario
            if (Superuser::where('user_id', auth()->id())->exists()) {
                return redirect()->route('initialize'); // Ruta protegida para superusuario
            }

            // Si no es superusuario, redirigir a otra parte (opcional)
            return redirect()->route('dashboard.dashboard');
        }

        // Si las credenciales son incorrectas, redirigir al login con error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    // Logout management
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
