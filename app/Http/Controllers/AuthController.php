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

        if (Auth::attempt($credentials)) {
            // Check superusuario
            if (Superuser::where('user_id', auth()->id())->exists()) {
                return redirect()->route('initialize'); // Protected route for superuser
            }
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    // Logout management
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
