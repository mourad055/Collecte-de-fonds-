<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\Paiement;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
            'solde_cli'    => 'required|numeric|min:0', // ✅ Changé de string à numeric
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
                'name' => $request->nom_cli . ' ' . $request->prenom_cli, // ✅ Ajout du name
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
            'solde_cli'    => 'required|numeric|min:0', // ✅ Changé de string à numeric
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
     * ✅ TABLEAU DE BORD D'UN CLIENT AUTHENTIFIÉ - CORRIGÉ
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

        // ✅ CORRECTION PRINCIPALE : Récupérer les VRAIS paiements depuis la BD
        
        // 1. Récupérer les PAIEMENTS du client
        $paiements = Paiement::where('id_cli', $client->id_cli)
            ->with(['collecteur']) // Charger la relation collecteur
            ->orderBy('date_paie', 'desc')
            ->get();

        // 2. Récupérer les TRANSACTIONS du client (si applicable)
        $transactionsList = Transaction::where('id_cli', $client->id_cli)
            ->with(['collecteur']) // Charger la relation collecteur
            ->orderBy('date_transact', 'desc')
            ->get();

        // 3. Fusionner les paiements et transactions en un seul historique
        $transactions = collect();

        // Ajouter les paiements
        foreach($paiements as $paiement) {
            $transactions->push((object)[
                'id' => $paiement->id_paie,
                'created_at' => Carbon::parse($paiement->date_paie),
                'type' => 'paiement',
                'montant' => $paiement->montant_paie,
                'statut' => $paiement->statut_paie, // 'validé', 'en_attente', 'rejeté'
                'collecteur' => $paiement->collecteur ? 
                    $paiement->collecteur->nom_collect . ' ' . $paiement->collecteur->prenom_collect : 
                    'N/A',
                'source' => 'paiement'
            ]);
        }

        // Ajouter les transactions
        foreach($transactionsList as $trans) {
            $transactions->push((object)[
                'id' => $trans->id_transact,
                'created_at' => Carbon::parse($trans->date_transact),
                'type' => 'transaction',
                'montant' => $trans->montant_transact,
                'statut' => 'validé', // Les transactions sont généralement validées
                'collecteur' => $trans->collecteur ? 
                    $trans->collecteur->nom_collect . ' ' . $trans->collecteur->prenom_collect : 
                    'N/A',
                'source' => 'transaction'
            ]);
        }

        // Trier par date décroissante
        $transactions = $transactions->sortByDesc('created_at')->values();

        return view('client.dashboard', [
            'solde'         => $client->solde_cli,
            'client'        => $client,
            'transactions'  => $transactions, // ✅ Maintenant avec de vraies données !
        ]);
    }
}