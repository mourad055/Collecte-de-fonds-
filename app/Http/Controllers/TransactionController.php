<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TransactionController extends Controller
{
    /**
     * Afficher la liste des transactions avec filtres
     */
    public function index(Request $request): View
    {
        $query = Transaction::query();

        // Appliquer les filtres
        $query->type($request->type)
              ->statut($request->statut)
              ->periode($request->date_debut, $request->date_fin)
              ->montant($request->montant_min, $request->montant_max);

        // Recherche par nom client ou numéro reçu
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nom_client', 'like', '%' . $request->search . '%')
                  ->orWhere('numero_recu', 'like', '%' . $request->search . '%');
            });
        }

        // Récupérer les transactions paginées
        $transactions = $query->orderBy('date_paiement', 'desc')
                             ->orderBy('created_at', 'desc')
                             ->paginate(50)
                             ->withQueryString();

        // Obtenir les statistiques
        $stats = Transaction::obtenirStatistiques(
            $request->date_debut,
            $request->date_fin
        );

        return view('transactions.index', compact('transactions', 'stats'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create(): View
    {
        return view('transactions.create');
    }

    /**
     * Enregistrer une nouvelle transaction
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom_client' => 'required|string|max:255',
            'type' => 'required|in:encaissement,decaissement',
            'montant' => 'required|numeric|min:0',
            'mode_paiement' => 'required|string|max:50',
            'date_paiement' => 'required|date',
            'statut' => 'required|in:valide,en-attente,annule',
            'description' => 'nullable|string',
        ]);

        // Générer automatiquement le numéro de reçu
        $validated['numero_recu'] = Transaction::genererNumeroRecu();

        Transaction::create($validated);

        return redirect()->route('transactions.index')
                        ->with('success', 'Transaction créée avec succès !');
    }

    /**
     * Afficher une transaction spécifique
     */
    public function show(Transaction $transaction): View
    {
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Transaction $transaction): View
    {
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Mettre à jour une transaction
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'nom_client' => 'required|string|max:255',
            'type' => 'required|in:encaissement,decaissement',
            'montant' => 'required|numeric|min:0',
            'mode_paiement' => 'required|string|max:50',
            'date_paiement' => 'required|date',
            'statut' => 'required|in:valide,en-attente,annule',
            'description' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
                        ->with('success', 'Transaction mise à jour avec succès !');
    }

    /**
     * Supprimer une transaction
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return redirect()->route('transactions.index')
                        ->with('success', 'Transaction supprimée avec succès !');
    }

    /**
     * Exporter les transactions en CSV
     */
    public function export(Request $request)
    {
        $query = Transaction::query();

        // Appliquer les mêmes filtres
        $query->type($request->type)
              ->statut($request->statut)
              ->periode($request->date_debut, $request->date_fin)
              ->montant($request->montant_min, $request->montant_max);

        $transactions = $query->orderBy('date_paiement', 'desc')->get();

        $filename = 'transactions_' . now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'Numéro Reçu',
                'Nom Client',
                'Type',
                'Montant',
                'Mode Paiement',
                'Date Paiement',
                'Statut',
                'Description'
            ]);

            // Données
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->numero_recu,
                    $transaction->nom_client,
                    $transaction->type,
                    $transaction->montant,
                    $transaction->mode_paiement,
                    $transaction->date_paiement->format('d/m/Y'),
                    $transaction->statut,
                    $transaction->description,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
```

