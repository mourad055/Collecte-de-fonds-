<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Collecteur;
use App\Models\Transaction;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Afficher le dashboard admin
     */
    public function dashboard()
    {
        // Statistiques générales
        $totalClients = Client::count();
        $totalCollecteurs = Collecteur::count();
        $totalTransactions = Transaction::count();
        $totalPaiements = Paiement::count();
        
        // Statistiques financières
        $totalEncaissements = Paiement::where('statut_paie', 'validé')
            ->sum('montant_paie');
        $totalTransactionsMontant = Transaction::sum('montant_transact');
        $paiementsEnAttente = Paiement::where('statut_paie', 'en_attente')->count();
        $montantEnAttente = Paiement::where('statut_paie', 'en_attente')
            ->sum('montant_paie');
        
        // Statistiques par période (ce mois)
        $paiementsCeMois = Paiement::whereMonth('date_paie', Carbon::now()->month)
            ->whereYear('date_paie', Carbon::now()->year)
            ->where('statut_paie', 'validé')
            ->sum('montant_paie');
        
        // Transactions récentes
        $transactionsRecent = Transaction::with(['client', 'collecteur'])
            ->orderBy('date_transact', 'desc')
            ->limit(10)
            ->get();
        
        // Paiements récents
        $paiementsRecent = Paiement::with(['client', 'collecteur'])
            ->orderBy('date_paie', 'desc')
            ->limit(10)
            ->get();
        
        // Top collecteurs par montant collecté
        $topCollecteurs = Collecteur::withSum(['paiements' => function($query) {
            $query->where('statut_paie', 'validé');
        }], 'montant_paie')
        ->orderBy('paiements_sum_montant_paie', 'desc')
        ->limit(5)
        ->get();
        
        // Graphique des paiements par mois (6 derniers mois)
        $paiementsParMois = Paiement::select(
            DB::raw('MONTH(date_paie) as mois'),
            DB::raw('YEAR(date_paie) as annee'),
            DB::raw('SUM(montant_paie) as total')
        )
        ->where('statut_paie', 'validé')
        ->where('date_paie', '>=', Carbon::now()->subMonths(6))
        ->groupBy('mois', 'annee')
        ->orderBy('annee')
        ->orderBy('mois')
        ->get();
        
        return view('admin.dashboard', compact(
            'totalClients',
            'totalCollecteurs',
            'totalTransactions',
            'totalPaiements',
            'totalEncaissements',
            'totalTransactionsMontant',
            'paiementsEnAttente',
            'montantEnAttente',
            'paiementsCeMois',
            'transactionsRecent',
            'paiementsRecent',
            'topCollecteurs',
            'paiementsParMois'
        ));
    }
    
    /**
     * Gestion des collecteurs - Liste
     */
    public function collecteurs()
    {
        $collecteurs = Collecteur::withCount(['paiements', 'transactions'])
            ->withSum(['paiements' => function($query) {
                $query->where('statut_paie', 'validé');
            }], 'montant_paie')
            ->orderBy('nom_collect')
            ->get();
        
        return view('admin.collecteurs.index', compact('collecteurs'));
    }
    
    /**
     * Afficher le formulaire de création de collecteur
     */
    public function createCollecteur()
    {
        return view('admin.collecteurs.create');
    }
    
    /**
     * Enregistrer un nouveau collecteur
     */
    public function storeCollecteur(Request $request)
    {
        $request->validate([
            'nom_collect' => 'required|string|max:100',
            'prenom_collect' => 'required|string|max:100',
            'tel_collect' => 'required|string|max:20',
            'zone_collect' => 'required|string|max:255',
        ]);
        
        Collecteur::create($request->only([
            'nom_collect',
            'prenom_collect',
            'tel_collect',
            'zone_collect'
        ]));
        
        return redirect()->route('admin.collecteurs')
            ->with('success', 'Collecteur ajouté avec succès');
    }
    
    /**
     * Afficher le formulaire d'édition de collecteur
     */
    public function editCollecteur($id)
    {
        $collecteur = Collecteur::findOrFail($id);
        return view('admin.collecteurs.edit', compact('collecteur'));
    }
    
    /**
     * Mettre à jour un collecteur
     */
    public function updateCollecteur(Request $request, $id)
    {
        $request->validate([
            'nom_collect' => 'required|string|max:100',
            'prenom_collect' => 'required|string|max:100',
            'tel_collect' => 'required|string|max:20',
            'zone_collect' => 'required|string|max:255',
        ]);
        
        $collecteur = Collecteur::findOrFail($id);
        $collecteur->update($request->only([
            'nom_collect',
            'prenom_collect',
            'tel_collect',
            'zone_collect'
        ]));
        
        return redirect()->route('admin.collecteurs')
            ->with('success', 'Collecteur modifié avec succès');
    }
    
    /**
     * Supprimer un collecteur
     */
    public function destroyCollecteur($id)
    {
        $collecteur = Collecteur::findOrFail($id);
        $collecteur->delete();
        
        return redirect()->route('admin.collecteurs')
            ->with('success', 'Collecteur supprimé avec succès');
    }
    
    /**
     * Gestion des clients - Liste
     */
    public function clients()
    {
        $clients = Client::withCount(['paiements', 'transactions'])
            ->withSum('paiements', 'montant_paie')
            ->orderBy('nom_cli')
            ->get();
        
        return view('admin.clients.index', compact('clients'));
    }
    
    /**
     * Afficher le formulaire de création de client
     */
    public function createClient()
    {
        return view('admin.clients.create');
    }
    
    /**
     * Enregistrer un nouveau client
     */
    public function storeClient(Request $request)
    {
        $request->validate([
            'nom_cli' => 'required|string|max:100',
            'prenom_cli' => 'required|string|max:100',
            'tel_cli' => 'required|string|max:20',
            'adresse_cli' => 'required|string|max:255',
            'solde_cli' => 'required|numeric|min:0',
        ]);
        
        Client::create($request->only([
            'nom_cli',
            'prenom_cli',
            'tel_cli',
            'adresse_cli',
            'solde_cli'
        ]));
        
        return redirect()->route('admin.clients')
            ->with('success', 'Client ajouté avec succès');
    }
    
    /**
     * Afficher le formulaire d'édition de client
     */
    public function editClient($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }
    
    /**
     * Mettre à jour un client
     */
    public function updateClient(Request $request, $id)
    {
        $request->validate([
            'nom_cli' => 'required|string|max:100',
            'prenom_cli' => 'required|string|max:100',
            'tel_cli' => 'required|string|max:20',
            'adresse_cli' => 'required|string|max:255',
            'solde_cli' => 'required|numeric|min:0',
        ]);
        
        $client = Client::findOrFail($id);
        $client->update($request->only([
            'nom_cli',
            'prenom_cli',
            'tel_cli',
            'adresse_cli',
            'solde_cli'
        ]));
        
        return redirect()->route('admin.clients')
            ->with('success', 'Client modifié avec succès');
    }
    
    /**
     * Supprimer un client
     */
    public function destroyClient($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        
        return redirect()->route('admin.clients')
            ->with('success', 'Client supprimé avec succès');
    }
    
    /**
     * Suivi des transactions
     */
    public function transactions(Request $request)
    {
        $query = Transaction::with(['client', 'collecteur']);
        
        // Filtres
        if ($request->filled('date_debut')) {
            $query->whereDate('date_transact', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('date_transact', '<=', $request->date_fin);
        }
        if ($request->filled('collecteur_id')) {
            $query->where('id_collect', $request->collecteur_id);
        }
        
        $transactions = $query->orderBy('date_transact', 'desc')->paginate(20);
        $collecteurs = Collecteur::all();
        
        return view('admin.transactions', compact('transactions', 'collecteurs'));
    }
    
    /**
     * Contrôle des encaissements (paiements)
     */
    public function encaissements(Request $request)
    {
        $query = Paiement::with(['client', 'collecteur']);
        
        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut_paie', $request->statut);
        }
        if ($request->filled('date_debut')) {
            $query->whereDate('date_paie', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('date_paie', '<=', $request->date_fin);
        }
        if ($request->filled('collecteur_id')) {
            $query->where('id_collect', $request->collecteur_id);
        }
        
        $paiements = $query->orderBy('date_paie', 'desc')->paginate(20);
        $collecteurs = Collecteur::all();
        
        return view('admin.encaissements', compact('paiements', 'collecteurs'));
    }
    
    /**
     * Valider un paiement
     */
    public function validerPaiement($id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->update(['statut_paie' => 'validé']);
        
        return redirect()->back()->with('success', 'Paiement validé avec succès');
    }
    
    /**
     * Rejeter un paiement
     */
    public function rejeterPaiement($id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->update(['statut_paie' => 'rejeté']);
        
        return redirect()->back()->with('success', 'Paiement rejeté');
    }
    
    /**
     * Export des rapports financiers (PDF)
     */
    public function exportRapportFinancier(Request $request)
    {
        $dateDebut = $request->date_debut ?? Carbon::now()->startOfMonth();
        $dateFin = $request->date_fin ?? Carbon::now()->endOfMonth();
        
        $paiements = Paiement::with(['client', 'collecteur'])
            ->whereBetween('date_paie', [$dateDebut, $dateFin])
            ->where('statut_paie', 'validé')
            ->get();
        
        $total = $paiements->sum('montant_paie');
        $nombrePaiements = $paiements->count();
        
        // Pour l'instant, on retourne une vue PDF simple
        // Vous pouvez utiliser DomPDF ou une autre bibliothèque pour générer un vrai PDF
        return view('admin.rapports.financier', compact('paiements', 'total', 'nombrePaiements', 'dateDebut', 'dateFin'));
    }
    
    /**
     * Export des statistiques
     */
    public function exportStatistiques(Request $request)
    {
        $periode = $request->periode ?? 'mois';
        
        $stats = [
            'total_clients' => Client::count(),
            'total_collecteurs' => Collecteur::count(),
            'total_paiements' => Paiement::where('statut_paie', 'validé')->count(),
            'total_encaissements' => Paiement::where('statut_paie', 'validé')->sum('montant_paie'),
            'paiements_par_collecteur' => Collecteur::withSum(['paiements' => function($query) {
                $query->where('statut_paie', 'validé');
            }], 'montant_paie')->get(),
        ];
        
        return view('admin.rapports.statistiques', compact('stats', 'periode'));
    }
}

