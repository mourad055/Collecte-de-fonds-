<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Collecteur;
use App\Models\Transaction;
use App\Models\Paiement;

class ChatAssistantController extends Controller
{
    /**
     * Handle an assistant question.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ask(Request $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'reply' => "Vous n'êtes pas authentifié. Veuillez vous connecter."
            ], 401);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:500',
        ], [
            'message.required' => 'Veuillez saisir une question.',
        ]);

        $message = trim($validated['message']);

        $reply = match ($user->role ?? null) {
            'admin' => $this->replyForAdmin($message),
            'collecteur' => $this->replyForCollecteur($user->related_id, $message),
            'client' => $this->replyForClient($user->related_id, $message),
            default => "Je ne parviens pas à identifier votre profil. Merci de vous reconnecter."
        };

        return response()->json([
            'reply' => $reply
        ]);
    }

    /**
     * Génère une réponse pour un administrateur.
     */
    private function replyForAdmin(string $message): string
    {
        $stats = $this->adminStats();

        if (!$stats) {
            return "Je n'ai pas pu charger les données. Réessayez dans un instant.";
        }

        $msg = Str::lower($message);

        if ($this->contains($msg, ['client'])) {
            return "Il y a actuellement {$stats['total_clients']} clients enregistrés.";
        }

        if ($this->contains($msg, ['collecteur'])) {
            $top = $stats['top_collecteurs']->map(fn ($c) => trim("{$c->nom_collect} {$c->prenom_collect}"))->take(3)->join(', ');
            $base = "Nous avons {$stats['total_collecteurs']} collecteurs actifs.";
            return $top ? "{$base} Les meilleurs sont : {$top}." : $base;
        }

        if ($this->contains($msg, ['paiement', 'encaissement', 'encaisse'])) {
            if ($this->contains($msg, ['attente', 'en attente'])) {
                return "Paiements en attente : {$stats['paiements_en_attente']} pour un montant total de {$this->formatCurrency($stats['montant_en_attente'])}.";
            }

            return "Encaissements validés : {$this->formatCurrency($stats['total_encaissements'])}. Ce mois-ci : {$this->formatCurrency($stats['paiements_ce_mois'])}.";
        }

        if ($this->contains($msg, ['transaction'])) {
            $latest = $stats['transactions_recent']->first();
            $lastInfo = $latest
                ? "Dernière transaction le " . Carbon::parse($latest->date_transact)->format('d/m/Y') .
                    " pour {$this->formatCurrency($latest->montant_transact)}."
                : "Aucune transaction récente.";
            return "Total transactions : {$stats['total_transactions']}. {$lastInfo}";
        }

        if ($this->contains($msg, ['rapport', 'statistique'])) {
            return "Pour exporter : bouton \"Exporter Rapport\" sur le tableau de bord. Les statistiques détaillées sont aussi disponibles sur la page Statistiques.";
        }

        if ($this->contains($msg, ['bonjour', 'salut', 'hello'])) {
            return "Bonjour ! Je peux vous donner les chiffres clés (clients, collecteurs, transactions, encaissements) ou l'état des paiements en attente.";
        }

        return "Je peux vous renseigner sur les clients, collecteurs, transactions, encaissements, paiements en attente ou les rapports. Par exemple : \"Combien de paiements en attente ?\" ou \"Montant encaissé ce mois-ci ?\"";
    }

    /**
     * Génère une réponse pour un collecteur.
     */
    private function replyForCollecteur(int $collecteurId, string $message): string
    {
        $stats = $this->collecteurStats($collecteurId);

        if (!$stats) {
            return "Impossible de récupérer vos informations de collecte. Vérifiez votre profil collecteur.";
        }

        $msg = Str::lower($message);

        if ($this->contains($msg, ['transaction'])) {
            $latest = $stats['transactions_recent']->first();
            $lastInfo = $latest
                ? "Dernière transaction le " . Carbon::parse($latest->date_transact)->format('d/m/Y') .
                    " pour {$this->formatCurrency($latest->montant_transact)}."
                : "Aucune transaction récente.";
            return "Vous avez enregistré {$stats['total_transactions']} transactions. {$lastInfo}";
        }

        if ($this->contains($msg, ['paiement', 'encaissement', 'collecte'])) {
            if ($this->contains($msg, ['attente', 'en attente'])) {
                return "Paiements en attente : {$stats['paiements_en_attente']} pour {$this->formatCurrency($stats['montant_en_attente'])}.";
            }

            return "Total encaissé (validé) : {$this->formatCurrency($stats['total_encaissements'])}. Ce mois-ci : {$this->formatCurrency($stats['paiements_ce_mois'])}.";
        }

        if ($this->contains($msg, ['client'])) {
            return "Vous suivez actuellement {$stats['total_clients']} clients (avec transactions ou paiements).";
        }

        if ($this->contains($msg, ['zone'])) {
            return "Zone attribuée : {$stats['collecteur']->zone_collect}.";
        }

        if ($this->contains($msg, ['bonjour', 'salut', 'hello'])) {
            return "Bonjour ! Je peux vous donner vos totaux (transactions, encaissements), le statut des paiements en attente ou votre zone.";
        }

        return "Je peux vous aider sur vos transactions, encaissements (validés ou en attente), vos clients et votre zone. Exemple : \"Montant encaissé ce mois-ci ?\" ou \"Combien de paiements en attente ?\"";
    }

    /**
     * Génère une réponse pour un client.
     */
    private function replyForClient(int $clientId, string $message): string
    {
        $stats = $this->clientStats($clientId);

        if (!$stats) {
            return "Je ne trouve pas votre fiche client. Merci de vous reconnecter.";
        }

        $msg = Str::lower($message);

        if ($this->contains($msg, ['solde', 'balance'])) {
            return "Votre solde actuel est de {$this->formatCurrency($stats['solde'])}.";
        }

        if ($this->contains($msg, ['transaction', 'historique', 'dernier'])) {
            $latest = $stats['transactions']->first();
            if ($latest) {
                $when = $latest->date_transact ?? $latest->created_at;
                $date = $when ? Carbon::parse($when)->format('d/m/Y') : 'date inconnue';
                $amount = $this->formatCurrency($latest->montant_transact ?? 0);
                return "Dernière transaction du {$date} pour {$amount}.";
            }

            return "Aucune transaction enregistrée.";
        }

        if ($this->contains($msg, ['paiement', 'encaissement'])) {
            return $stats['paiements_recent']->isNotEmpty()
                ? "Dernier paiement du " . Carbon::parse($stats['paiements_recent']->first()->date_paie)->format('d/m/Y') .
                    " pour {$this->formatCurrency($stats['paiements_recent']->first()->montant_paie)} (statut : {$stats['paiements_recent']->first()->statut_paie})."
                : "Aucun paiement enregistré pour le moment.";
        }

        if ($this->contains($msg, ['aide', 'contact'])) {
            return "Pour toute assistance, contactez votre collecteur ou l'administrateur depuis le tableau de bord.";
        }

        if ($this->contains($msg, ['bonjour', 'salut', 'hello'])) {
            return "Bonjour ! Je peux vous donner votre solde, vos dernières transactions ou l'état de vos paiements.";
        }

        return "Posez-moi une question sur votre solde, vos transactions récentes ou vos paiements. Exemples : \"Quel est mon solde ?\" ou \"Dernier paiement ?\"";
    }

    /**
     * Statistiques globales pour l'admin.
     */
    private function adminStats(): ?array
    {
        try {
            return [
                'total_clients' => Client::count(),
                'total_collecteurs' => Collecteur::count(),
                'total_transactions' => Transaction::count(),
                'total_encaissements' => Paiement::where('statut_paie', 'validé')->sum('montant_paie'),
                'paiements_en_attente' => Paiement::where('statut_paie', 'en_attente')->count(),
                'montant_en_attente' => Paiement::where('statut_paie', 'en_attente')->sum('montant_paie'),
                'paiements_ce_mois' => Paiement::whereMonth('date_paie', Carbon::now()->month)
                    ->whereYear('date_paie', Carbon::now()->year)
                    ->where('statut_paie', 'validé')
                    ->sum('montant_paie'),
                'transactions_recent' => Transaction::with(['client', 'collecteur'])
                    ->orderBy('date_transact', 'desc')
                    ->limit(3)
                    ->get(),
                'paiements_recent' => Paiement::with(['client', 'collecteur'])
                    ->orderBy('date_paie', 'desc')
                    ->limit(3)
                    ->get(),
                'top_collecteurs' => Collecteur::withSum(['paiements' => function ($query) {
                    $query->where('statut_paie', 'validé');
                }], 'montant_paie')
                    ->orderBy('paiements_sum_montant_paie', 'desc')
                    ->limit(3)
                    ->get(),
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Statistiques pour un collecteur.
     */
    private function collecteurStats(int $collecteurId): ?array
    {
        try {
            $collecteur = Collecteur::findOrFail($collecteurId);

            $clientIdsTransactions = Transaction::where('id_collect', $collecteurId)
                ->pluck('id_cli')
                ->unique();
            $clientIdsPaiements = Paiement::where('id_collect', $collecteurId)
                ->pluck('id_cli')
                ->unique();

            return [
                'collecteur' => $collecteur,
                'total_transactions' => Transaction::where('id_collect', $collecteurId)->count(),
                'total_encaissements' => Paiement::where('id_collect', $collecteurId)
                    ->where('statut_paie', 'validé')
                    ->sum('montant_paie'),
                'paiements_en_attente' => Paiement::where('id_collect', $collecteurId)
                    ->where('statut_paie', 'en_attente')
                    ->count(),
                'montant_en_attente' => Paiement::where('id_collect', $collecteurId)
                    ->where('statut_paie', 'en_attente')
                    ->sum('montant_paie'),
                'paiements_ce_mois' => Paiement::where('id_collect', $collecteurId)
                    ->whereMonth('date_paie', Carbon::now()->month)
                    ->whereYear('date_paie', Carbon::now()->year)
                    ->where('statut_paie', 'validé')
                    ->sum('montant_paie'),
                'total_clients' => $clientIdsTransactions->merge($clientIdsPaiements)->unique()->count(),
                'transactions_recent' => Transaction::where('id_collect', $collecteurId)
                    ->orderBy('date_transact', 'desc')
                    ->limit(3)
                    ->get(),
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Statistiques pour un client.
     */
    private function clientStats(int $clientId): ?array
    {
        try {
            $client = Client::findOrFail($clientId);

            return [
                'client' => $client,
                'solde' => $client->solde_cli,
                'transactions' => Transaction::where('id_cli', $clientId)
                    ->orderBy('date_transact', 'desc')
                    ->limit(3)
                    ->get(),
                'paiements_recent' => Paiement::where('id_cli', $clientId)
                    ->orderBy('date_paie', 'desc')
                    ->limit(3)
                    ->get(),
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Vérifie si un message contient l'un des mots clés.
     */
    private function contains(string $message, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (Str::contains($message, Str::lower($needle))) {
                return true;
            }
        }

        return false;
    }

    private function formatCurrency(float|int $value): string
    {
        $numeric = is_numeric($value) ? (float) $value : 0;
        return number_format($numeric, 0, ',', ' ') . ' FCFA';
    }
}
