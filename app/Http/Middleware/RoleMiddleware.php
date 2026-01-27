<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Vérifier si l'utilisateur a le bon rôle
        if (Auth::user()->role !== $role) {
            // Rediriger vers le dashboard approprié selon le rôle de l'utilisateur
            return $this->redirectToDashboard(Auth::user()->role);
        }

        return $next($request);
    }

    /**
     * Rediriger vers le dashboard approprié selon le rôle
     *
     * @param string $role
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectToDashboard(string $role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Vous n\'avez pas accès à cette page.');
            
            case 'collecteur':
                return redirect()->route('collecteur.dashboard')
                    ->with('error', 'Vous n\'avez pas accès à cette page.');
            
            case 'client':
                return redirect()->route('client.dashboard')
                    ->with('error', 'Vous n\'avez pas accès à cette page.');
            
            default:
                return redirect()->route('login')
                    ->with('error', 'Rôle utilisateur non reconnu.');
        }
    }
}