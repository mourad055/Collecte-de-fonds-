<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function showLogin()
    {
        return view('client.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'telephone' => 'required',
            'password' => 'required',
        ]);

        $client = Client::where('telephone', $request->telephone)->first();

        if ($client && Hash::check($request->password, $client->password)) {
            Auth::guard('client')->login($client);
            $client->update(['derniere_connexion' => now()]);
            return redirect()->route('client.dashboard');
        }

        return back()->withErrors(['telephone' => 'Identifiants incorrects']);
    }

    public function logout()
    {
        Auth::guard('client')->logout();
        return redirect()->route('client.login');
    }

    public function dashboard()
    {
        $client = Auth::guard('client')->user();
        $transactions = $client->transactions()->take(5)->get();
        $notifications = $client->notifications()->where('lu', false)->take(3)->get();
        
        return view('client.dashboard', compact('client', 'transactions', 'notifications'));
    }

    public function solde()
    {
        $client = Auth::guard('client')->user();
        return view('client.solde', compact('client'));
    }

    public function historique()
    {
        $client = Auth::guard('client')->user();
        $transactions = $client->transactions()->paginate(20);
        
        return view('client.historique', compact('transactions'));
    }

    public function notifications()
    {
        $client = Auth::guard('client')->user();
        $notifications = $client->notifications()->paginate(20);
        
        $client->notifications()->where('lu', false)->update(['lu' => true]);
        
        return view('client.notifications', compact('notifications'));
    }

    public function profil()
    {
        $client = Auth::guard('client')->user();
        return view('client.profil', compact('client'));
    }
}