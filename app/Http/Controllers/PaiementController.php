<?php
namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Client;
use App\Models\Recu;
use Illuminate\Http\Request;

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

        // Préparation des données exactes pour la table paiements
        // Table: paiements, champs essentiels d'après la logique : id_cli, montant_paie, date_paie, id_collect (optionnel), statut_paie (défaut: effectué)
        $paiementData = [
            'id_cli'        => $validated['client_id'], // id_cli (clé étrangère liée à clients)
            'montant_paie'  => $validated['montant'],
            'date_paie'     => $validated['date_paiement'],
            'id_collect'    => auth()->user()->id_collect ?? null, // clé collecteur, optionnelle selon structure utilisateur
            'statut_paie'   => 'effectué',
            // 'reference'  => $validated['reference'] ?? null, // Décommenter si le champ existe dans la migration/table paiements
        ];

        // Si le champ "reference" existe dans la table paiements ET dans le modèle Paiement, décommente la ligne suivante :
        // if (isset($validated['reference'])) $paiementData['reference'] = $validated['reference'];

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

        // On charge bien la relation correct client() du modèle Paiement : belongsTo(Client::class, 'id_cli', 'id_cli')
        $paiement->load('client');

        // On retourne la vue du reçu en passant uniquement les noms corrects (cf. structure client & paiement)
        return view('recu.generate', [
            'client'        => $paiement->client, // doit être un objet Client (id_cli, nom_cli, prenom_cli, etc.)
            'numero_recu'   => $numero_recu,
            'nom'           => $paiement->client->nom_cli ?? '',
            'prenom'        => $paiement->client->prenom_cli ?? '',
            'reference'     => $validated['reference'] ?? '',
            'montant'       => $paiement->montant_paie,
            'mode_paiement' => $validated['mode_paiement'],
            'date_paiement' => $validated['date_paiement'],
        ]);
    }

    // Liste de tous les paiements avec chargement relation client, en affichant bien les bons champs
    public function index()
    {
        $paiements = Paiement::with('client')->get(); // la relation client doit bien pointer vers 'id_cli'
        return view('paiement.index', compact('paiements'));
    }
}

/*
    À RESPECTER POUR EVITER LES ERREURS D'APPELLATION :
    1. Le modèle Paiement (app/Models/Paiement.php) doit contenir :
        public function client() { return $this->belongsTo(Client::class, 'id_cli', 'id_cli'); }
    2. Le modèle Client (app/Models/Client.php) a pour clé primaire protégée $primaryKey = 'id_cli'
       et les champs fillable corrects (voir migration) : ['nom_cli','prenom_cli','tel_cli','adresse_cli','solde_cli']
    3. La vue paiement.blade.php doit bien générer <option value="{{$client->id_cli}}">{{$client->nom_cli}} {{$client->prenom_cli}}</option>
    4. Tous les champs doivent matcher strictement entre les formulaires et la BDD.
    5. "reference" n'est traitée qu'à condition qu'elle existe en BDD et dans le modèle Paiement.
    6. Pour chaque variable utilisée dans une vue ou contrôleur, assure-toi qu'elle existe dans la base, la migration et le modèle associé !
*/