<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class EncaissementController extends Controller
{
    /**
     * Afficher le tableau de bord de contrôle des encaissements
     */
    public function index(Request $request): View
    {
        $query = Transaction::with(['client', 'collecteur'])
                           ->where('type_transact', 'encaissement');

        // Appliquer les filtres
        if ($request->filled('statut_controle')) {
            if ($request->statut_controle === 'non_controle') {
                $query->where('est_controle', false);
            } elseif ($request->statut_controle === 'controle') {
                $query->where('est_controle', true);
            }
        }

        if ($request->filled('resultat_controle')) {
            $query->where('resultat_controle', $request->resultat_controle);
        }

        if ($request->filled('date_debut')) {
            $query->where('date_transact', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->where('date_transact', '<=', $request->date_fin);
        }

        if ($request->filled('montant_min')) {
            $query->where('montant_transact', '>=', $request->montant_min);
        }

        if ($request->filled('montant_max')) {
            $query->where('montant_transact', '<=', $request->montant_max);
        }

        // Recherche par client ou collecteur
        if ($request->filled('search')) {
            $query->whereHas('client', function($q) use ($request) {
                $q->where('nom_cli', 'like', '%' . $request->search . '%');
            })->orWhereHas('collecteur', function($q) use ($request) {
                $q->where('nom_collect', 'like', '%' . $request->search . '%');
            });
        }

        // Récupérer les encaissements
        $encaissements = $query->orderBy('date_transact', 'desc')
                              ->orderBy('created_at', 'desc')
                              ->paginate(50)
                              ->withQueryString();

        // Obtenir les statistiques
        $stats = Transaction::obtenirStatistiquesControle(
            $request->date_debut,
            $request->date_fin
        );

        return view('encaissements.controle', compact('encaissements', 'stats'));
    }

    /**
     * Valider un encaissement
     */
    public function valider(Request $request, $id): RedirectResponse
    {
        $transaction = Transaction::findOrFail($id);

        // Vérifier que c'est bien un encaissement
        if ($transaction->type_transact !== 'encaissement') {
            return redirect()->back()->with('error', 'Cette transaction n\'est pas un encaissement.');
        }

        $validated = $request->validate([
            'note_controle' => 'nullable|string|max:1000',
        ]);

        // Marquer comme validé
        $transaction->marquerControle(
            'valide',
            $validated['note_controle'] ?? null,
            auth()->id() ?? 1 // ID du contrôleur connecté
        );

        return redirect()->back()->with('success', 'Encaissement validé avec succès !');
    }

    /**
     * Rejeter un encaissement
     */
    public function rejeter(Request $request, $id): RedirectResponse
    {
        $transaction = Transaction::findOrFail($id);

        // Vérifier que c'est bien un encaissement
        if ($transaction->type_transact !== 'encaissement') {
            return redirect()->back()->with('error', 'Cette transaction n\'est pas un encaissement.');
        }

        $validated = $request->validate([
            'note_controle' => 'required|string|max:1000',
        ], [
            'note_controle.required' => 'Vous devez indiquer la raison du rejet.'
        ]);

        // Marquer comme rejeté
        $transaction->marquerControle(
            'rejete',
            $validated['note_controle'],
            auth()->id() ?? 1
        );

        return redirect()->back()->with('success', 'Encaissement rejeté avec succès !');
    }

    /**
     * Marquer en vérification
     */
    public function enVerification(Request $request, $id): RedirectResponse
    {
        $transaction = Transaction::findOrFail($id);

        $validated = $request->validate([
            'note_controle' => 'nullable|string|max:1000',
        ]);

        $transaction->marquerControle(
            'en_verification',
            $validated['note_controle'] ?? null,
            auth()->id() ?? 1
        );

        return redirect()->back()->with('success', 'Encaissement marqué en vérification.');
    }

    /**
     * Validation en masse
     */
    public function validerEnMasse(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'transaction_ids' => 'required|array',
            'transaction_ids.*' => 'exists:transactions,id_transact',
            'note_controle' => 'nullable|string|max:1000',
        ]);

        $count = 0;
        foreach ($validated['transaction_ids'] as $id) {
            $transaction = Transaction::find($id);
            if ($transaction && $transaction->type_transact === 'encaissement' && !$transaction->est_controle) {
                $transaction->marquerControle(
                    'valide',
                    $validated['note_controle'] ?? 'Validation en masse',
                    auth()->id() ?? 1
                );
                $count++;
            }
        }

        return redirect()->back()->with('success', "$count encaissement(s) validé(s) avec succès !");
    }

    /**
     * Annuler le contrôle (remettre en non contrôlé)
     */
    public function annulerControle($id): RedirectResponse
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->est_controle = false;
        $transaction->resultat_controle = null;
        $transaction->note_controle = null;
        $transaction->controleur_id = null;
        $transaction->date_controle = null;
        $transaction->save();

        return redirect()->back()->with('success', 'Contrôle annulé. L\'encaissement est de nouveau non contrôlé.');
    }

    /**
     * Afficher les détails d'un encaissement
     */
    public function show($id): View
    {
        $transaction = Transaction::with(['client', 'collecteur'])->findOrFail($id);
        return view('encaissements.show', compact('transaction'));
    }

    /**
     * Exporter le rapport de contrôle en CSV
     */
    public function exporterRapport(Request $request)
    {
        $query = Transaction::with(['client', 'collecteur'])
                           ->where('type_transact', 'encaissement');

        // Appliquer les filtres
        if ($request->filled('statut_controle')) {
            if ($request->statut_controle === 'non_controle') {
                $query->where('est_controle', false);
            } elseif ($request->statut_controle === 'controle') {
                $query->where('est_controle', true);
            }
        }

        if ($request->filled('resultat_controle')) {
            $query->where('resultat_controle', $request->resultat_controle);
        }

        if ($request->filled('date_debut')) {
            $query->where('date_transact', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->where('date_transact', '<=', $request->date_fin);
        }

        $encaissements = $query->orderBy('date_transact', 'desc')->get();

        $filename = 'rapport_controle_encaissements_' . now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($encaissements) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID Transaction',
                'Date Transaction',
                'Client',
                'Collecteur',
                'Montant',
                'Contrôlé',
                'Résultat Contrôle',
                'Date Contrôle',
                'Note Contrôle',
                'Statut'
            ]);

            // Données
            foreach ($encaissements as $enc) {
                fputcsv($file, [
                    $enc->id_transact,
                    $enc->date_transact->format('d/m/Y'),
                    $enc->client->nom_cli ?? 'N/A',
                    $enc->collecteur->nom_collect ?? 'N/A',
                    $enc->montant_transact,
                    $enc->est_controle ? 'Oui' : 'Non',
                    $enc->resultat_controle ?? 'N/A',
                    $enc->date_controle ? $enc->date_controle->format('d/m/Y H:i') : 'N/A',
                    $enc->note_controle ?? '',
                    $enc->statut_transact ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Générer un rapport de synthèse
     */
    public function rapportSynthese(Request $request): View
    {
        $dateDebut = $request->date_debut;
        $dateFin = $request->date_fin;

        $stats = Transaction::obtenirStatistiquesControle($dateDebut, $dateFin);

        // Répartition par collecteur
        $parCollecteur = Transaction::with('collecteur')
            ->where('type_transact', 'encaissement')
            ->when($dateDebut, fn($q) => $q->where('date_transact', '>=', $dateDebut))
            ->when($dateFin, fn($q) => $q->where('date_transact', '<=', $dateFin))
            ->select('id_collect', DB::raw('COUNT(*) as total'), DB::raw('SUM(montant_transact) as montant_total'))
            ->groupBy('id_collect')
            ->get();

        // Répartition par résultat de contrôle
        $parResultat = Transaction::where('type_transact', 'encaissement')
            ->where('est_controle', true)
            ->when($dateDebut, fn($q) => $q->where('date_transact', '>=', $dateDebut))
            ->when($dateFin, fn($q) => $q->where('date_transact', '<=', $dateFin))
            ->select('resultat_controle', DB::raw('COUNT(*) as total'), DB::raw('SUM(montant_transact) as montant_total'))
            ->groupBy('resultat_controle')
            ->get();

        return view('encaissements.rapport', compact('stats', 'parCollecteur', 'parResultat', 'dateDebut', 'dateFin'));
    }
}
