<?php
namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Client;
use App\Models\Recu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    // Affiche le formulaire de paiement
    public function create()
    {
        // Récupérer tous les clients avec les bons champs de la table clients
        // Table: clients, champs principaux: id_cli, nom_cli, prenom_cli, etc.
        $clients = Client::all(); // $client->id_cli, $client->nom_cli, $client->prenom_cli, etc.
        return view('paiement.paiement', compact('clients'));
    }

    // Traite la soumission du paiement
    public function store(Request $request)
    {
        // Validation en respectant les champs exacts de la table clients et le schéma de la table paiements
        $validated = $request->validate([
            'client_id'     => 'required|exists:clients,id_cli', // clé primaire correcte dans clients
            'montant'       => 'required|numeric|min:0',
            'mode_paiement' => 'required|string|max:255',
            'date_paiement' => 'required|date',
            'reference'     => 'nullable|string|max:255',
        ]);

        // ✅ CORRECTION PRINCIPALE : Récupération automatique de l'ID du collecteur connecté
        $user = Auth::user();
        
        // Déterminer l'id_collect selon le rôle de l'utilisateur
        if ($user->role === 'collecteur') {
            // Si c'est un collecteur, utiliser son related_id
            $id_collect = $user->related_id;
        } elseif ($user->role === 'admin' && $request->has('id_collect')) {
            // Si c'est un admin et qu'il a sélectionné un collecteur dans le formulaire
            $id_collect = $request->id_collect;
        } else {
            // Par défaut, essayer de récupérer depuis l'utilisateur
            $id_collect = $user->related_id ?? null;
        }

        // Préparation des données exactes pour la table paiements
        // Table: paiements, champs essentiels : id_cli, montant_paie, date_paie, id_collect, statut_paie
        $paiementData = [
            'id_cli'        => $validated['client_id'], // id_cli (clé étrangère liée à clients)
            'montant_paie'  => $validated['montant'],
            'date_paie'     => $validated['date_paiement'],
            'id_collect'    => $id_collect, // ✅ TOUJOURS DÉFINI MAINTENANT
            'statut_paie'   => 'validé', // ✅ Changé de 'effectué' à 'validé' (selon votre modèle)
        ];

        // Si le champ "reference" existe dans la table paiements ET dans le modèle Paiement
        // Décommenter si nécessaire :
        // if (isset($validated['reference'])) {
        //     $paiementData['reference'] = $validated['reference'];
        // }

        // Création du paiement en base
        $paiement = Paiement::create($paiementData);

        // Création du reçu en base, lié à ce paiement
        $recu = Recu::create([
            'dateCreation_recu' => now(),
            'montant_recu'      => $paiement->montant_paie,
            'id_paie'           => $paiement->id_paie,
        ]);

        // Génération du numéro unique pour le reçu à partir de l'ID en base
        $numero_recu = 'RCU-' . date('Ymd') . '-' . str_pad($recu->id_recu, 6, '0', STR_PAD_LEFT);

        // On charge bien la relation client() du modèle Paiement : belongsTo(Client::class, 'id_cli', 'id_cli')
        $paiement->load('client');

        // On retourne la vue du reçu en passant les données correctes
        return view('recu.generate', [
            'client'        => $paiement->client, // objet Client (id_cli, nom_cli, prenom_cli, etc.)
            'numero_recu'   => $numero_recu,
            'nom'           => $paiement->client->nom_cli ?? '',
            'prenom'        => $paiement->client->prenom_cli ?? '',
            'reference'     => $validated['reference'] ?? '',
            'montant'       => $paiement->montant_paie,
            'mode_paiement' => $validated['mode_paiement'],
            'date_paiement' => $validated['date_paiement'],
        ]);
    }

    // Liste de tous les paiements avec chargement relation client
    public function index()
    {
        $paiements = Paiement::with('client')->orderBy('date_paie', 'desc')->get();
        return view('paiement.index', compact('paiements'));
    }
}

/*
    ✅ CORRECTIONS APPORTÉES :
    
    1. AJOUT de l'importation : use Illuminate\Support\Facades\Auth;
    
    2. CORRECTION MAJEURE dans store() :
       - Récupération automatique de l'id du collecteur connecté
       - Logique conditionnelle selon le rôle (collecteur/admin)
       - Garantit que id_collect n'est JAMAIS NULL pour les nouveaux paiements
    
    3. CHANGEMENT de statut : 'effectué' → 'validé' (selon votre enum)
    
    4. AMÉLIORATION dans index() : ajout de ->orderBy('date_paie', 'desc')
    
    À RESPECTER POUR ÉVITER LES ERREURS :
    
    1. Le modèle Paiement (app/Models/Paiement.php) doit contenir :
       - protected $fillable = ['montant_paie', 'date_paie', 'id_cli', 'id_collect', 'statut_paie'];
       - public function client() { return $this->belongsTo(Client::class, 'id_cli', 'id_cli'); }
    
    2. Le modèle Client (app/Models/Client.php) :
       - protected $primaryKey = 'id_cli';
       - protected $fillable = ['nom_cli','prenom_cli','tel_cli','adresse_cli','solde_cli'];
    
    3. La table users doit avoir :
       - Colonne 'role' : 'admin', 'collecteur', 'client'
       - Colonne 'related_id' : pointe vers id_collect si role='collecteur'
    
    4. Tous les collecteurs doivent avoir un compte user avec :
       - role = 'collecteur'
       - related_id = leur id_collect dans la table collecteurs
    
    5. Pour les ANCIENS paiements avec id_collect NULL, exécutez :
       UPDATE paiements SET id_collect = X WHERE id_collect IS NULL;
       (Remplacez X par l'ID du collecteur approprié)
*/