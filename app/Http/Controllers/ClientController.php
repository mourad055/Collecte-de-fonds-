<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * Afficher la liste des clients
     * GET /clients
     */
    public function index()
    {
        // Récupérer tous les clients depuis la base de données
        $clients = Client::all();

        // Envoyer les clients à la vue liste_client
        return view('client.liste_client', compact('clients'));
    }

    /**
     * Afficher le formulaire d'ajout
     * GET /clients/create
     */
    public function create()
    {
        return view('client.ajout_client');
    }

    /**
     * Enregistrer un nouveau client
     * POST /clients
     */
    public function store(Request $request)
    {
        // Validation des données envoyées par le formulaire
        $request->validate([
            'nom_cli'      => 'required|string|max:100',
            'prenom_cli'   => 'required|string|max:100',
            'tel_cli'      => 'required|string|max:20',
            'adresse_cli'  => 'required|string|max:255',
            'solde_cli'    => 'required|string|max:100',
            'user_email'   => 'nullable|email|unique:users,email',
            'user_password' => 'nullable|string|min:6|confirmed',
        ]);

        // Création du client
        $client = Client::create([
            'nom_cli'      => $request->nom_cli,
            'prenom_cli'   => $request->prenom_cli,
            'tel_cli'      => $request->tel_cli,
            'adresse_cli'  => $request->adresse_cli,
            'solde_cli'    => $request->solde_cli,
        ]);

        // Si des identifiants sont fournis, on crée aussi un compte utilisateur client
        if ($request->filled('user_email') && $request->filled('user_password')) {
            User::create([
                'email' => $request->user_email,
                'password' => Hash::make($request->user_password),
                'role' => 'client',
                'related_id' => $client->id_cli,
            ]);
        }

        // Redirection vers la liste avec message de succès
        return redirect()
            ->route('clients.index')
            ->with('success', 'Client ajouté avec succès');
    }

    /**
     * Afficher le formulaire de modification
     * GET /clients/{id}/edit
     */
    public function edit($id)
    {
        // Trouver le client ou afficher une erreur 404
        $client = Client::findOrFail($id);

        return view('client.modifier', compact('client'));
    }

    /**
     * Mettre à jour un client
     * PUT /clients/{id}
     */
    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'nom_cli'      => 'required|string|max:100',
            'prenom_cli'   => 'required|string|max:100',
            'tel_cli'      => 'required|string|max:20',
            'adresse_cli'  => 'required|string|max:255',
            'solde_cli'    => 'required|string|max:100',
        ]);

        // Récupération du client
        $client = Client::findOrFail($id);

        // Mise à jour
        $client->update([
            'nom_cli'      => $request->nom_cli,
            'prenom_cli'   => $request->prenom_cli,
            'tel_cli'      => $request->tel_cli,
            'adresse_cli'  => $request->adresse_cli,
            'solde_cli'    => $request->solde_cli,
        ]);

        // Redirection vers la liste
        return redirect()
            ->route('clients.index')
            ->with('success', 'Client modifié avec succès');
    }

    /**
     * Supprimer un client
     * DELETE /clients/{id}
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client supprimé avec succès');
    }

    /**
     * Tableau de bord d'un client authentifié
     * GET /client/dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Récupération du client lié
        $client = Client::where('id_cli', $user->related_id)->first();

        // Sécurité si jamais
        if (!$client) {
            abort(404, 'Client introuvable');
        }

        return view('client.dashboard', [
            'solde'         => $client->solde_cli,
            'client'        => $client,
            // À brancher plus tard sur de vraies données de transaction
            'transactions'  => collect(),
        ]);
    }
}
