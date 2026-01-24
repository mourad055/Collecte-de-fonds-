<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Models\Notification as NotificationModel;

class TransactionObserver
{
    /**
     * Quand une transaction est créée, on crée automatiquement une notification
     */
    public function created(Transaction $transaction)
    {
        $client = $transaction->client;
        
        // Créer une notification automatique
        NotificationModel::create([
            'client_id' => $client->id,
            'titre' => ucfirst($transaction->type) . ' effectué',
            'message' => $this->generateMessage($transaction),
            'lu' => false,
        ]);
    }

    /**
     * Générer le message de notification selon le type de transaction
     */
    private function generateMessage(Transaction $transaction): string
    {
        $montant = number_format($transaction->montant, 0, ',', ' ') . ' FCFA';
        
        switch ($transaction->type) {
            case 'depot':
                return "Un dépôt de {$montant} a été effectué sur votre compte. {$transaction->description}";
            
            case 'retrait':
                return "Un retrait de {$montant} a été effectué. {$transaction->description}";
            
            case 'transfert':
                return "Un transfert de {$montant} a été réalisé. {$transaction->description}";
            
            default:
                return "Une transaction de {$montant} a été effectuée. {$transaction->description}";
        }
    }
}