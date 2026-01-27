<?php

namespace App\Http\Controllers;

use App\Models\Collecteur;
use App\Models\Transaction;
use App\Models\Paiement;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CollecteurController extends Controller
{
    /**
     * Afficher le dashboard du collecteur connecté
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Récupérer le collecteur connecté via related_id
        $collecteur = Collecteur::findOrFail($user->related_id);

        // Statistiques générales du collecteur
        $totalTransactions = Transaction::where('id_collect', $collecteur->id_collect)->count();
        $totalPaiements = Paiement::where('id_collect', $collecteur->id_collect)->count();

        // Compter les clients uniques qui ont des transactions ou paiements avec ce collecteur
        $clientIdsTransactions = Transaction::where('id_collect', $collecteur->id_collect)
            ->pluck('id_cli')
            ->unique();
        
        $clientIdsPaiements = Paiement::where('id_collect', $collecteur->id_collect)
            ->pluck('id_cli')
            ->unique();
        
        $totalClients = $clientIdsTransactions->merge($clientIdsPaiements)->unique()->count();

        // Statistiques financières
        $totalEncaissements = Paiement::where('id_collect', $collecteur->id_collect)
            ->where('statut_paie', 'validé')
            ->sum('montant_paie');

        $totalTransactionsMontant = Transaction::where('id_collect', $collecteur->id_collect)
            ->sum('montant_transact');

        $paiementsEnAttente = Paiement::where('id_collect', $collecteur->id_collect)
            ->where('statut_paie', 'en_attente')
            ->count();

        $montantEnAttente = Paiement::where('id_collect', $collecteur->id_collect)
            ->where('statut_paie', 'en_attente')
            ->sum('montant_paie');

        // Statistiques par période (ce mois)
        $paiementsCeMois = Paiement::where('id_collect', $collecteur->id_collect)
            ->whereMonth('date_paie', Carbon::now()->month)
            ->whereYear('date_paie', Carbon::now()->year)
            ->where('statut_paie', 'validé')
            ->sum('montant_paie');
        
        // Paiements aujourd'hui (montant total)
        $paiementsAujourdhui = Paiement::where('id_collect', $collecteur->id_collect)
            ->whereDate('date_paie', Carbon::today())
            ->where('statut_paie', 'validé')
            ->sum('montant_paie');

        // ✅ MODIFICATION PRINCIPALE : Paiements JOURNALIERS (aujourd'hui) au lieu de transactions récentes
        $paiementsJournaliers = Paiement::where('id_collect', $collecteur->id_collect)
            ->whereDate('date_paie', Carbon::today()) // ✅ Filtre sur aujourd'hui uniquement
            ->with(['client']) // Charger la relation client
            ->orderBy('date_paie', 'desc')
            ->get(); // ✅ Récupère TOUS les paiements du jour (pas de limite)

        // Nombre de paiements aujourd'hui
        $nombrePaiementsAujourdhui = $paiementsJournaliers->count();

        // Paiements récents (pour la carte des paiements récents - optionnel)
        $paiementsRecent = Paiement::where('id_collect', $collecteur->id_collect)
            ->with(['client'])
            ->orderBy('date_paie', 'desc')
            ->limit(5)
            ->get();

        // Historique complet des PAIEMENTS avec pagination
        $paiements = Paiement::where('id_collect', $collecteur->id_collect)
            ->with(['client'])
            ->orderBy('date_paie', 'desc')
            ->paginate(10);

        return view('collecteur.dashboard', compact(
            'collecteur',
            'totalTransactions',
            'totalPaiements',
            'totalClients',
            'totalEncaissements',
            'totalTransactionsMontant',
            'paiementsEnAttente',
            'montantEnAttente',
            'paiementsCeMois',
            'paiementsAujourdhui',
            'paiementsJournaliers',        // ✅ NOUVEAU : Liste des paiements du jour
            'nombrePaiementsAujourdhui',   // ✅ NOUVEAU : Nombre de paiements du jour
            'paiementsRecent',
            'paiements'
        ));
    }

    public function index()
    {
        return Collecteur::all();
    }
}