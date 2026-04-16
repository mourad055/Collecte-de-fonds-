<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirection selon le rôle AVEC le popup de succès
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard')->with('login_success', true),
                'collecteur' => redirect()->route('collecteur.dashboard')->with('login_success', true),
                'client' => redirect()->route('client.dashboard')->with('login_success', true),
            };
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}