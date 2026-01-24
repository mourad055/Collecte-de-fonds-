<?php

namespace App\Helpers;

use App\Models\Client;
use App\Models\Transaction;
use App\Models\Notification as NotificationModel;

class ClientHelper
{
    /**
     * Ajouter une transaction (avec mise à jour automatique du solde et notification)
     */
    public static function addTransaction($clientId, $type, $montant, $description = null)
    {
        $client = Client::find($clientId);
        
        if (!$client) {
            return ['error' => 'Client introuvable'];
        }

        // Créer la transaction
        $transaction = Transaction::create([
            'client_id' => $client->id,
            'type' => $type,
            'montant' => $montant,
            'description' => $description ?? ucfirst($type) . ' automatique',
            'reference' => strtoupper(substr($type, 0, 3)) . '-' . time() . '-' . rand(100, 999),
        ]);

        // Mettre à jour le solde automatiquement
        if ($type == 'depot') {
            $client->increment('solde', $montant);
        } else if ($type == 'retrait') {
            $client->decrement('solde', $montant);
        }

        return [
            'success' => true,
            'transaction' => $transaction,
            'nouveau_solde' => $client->fresh()->solde,
            'message' => "Transaction de {$montant} FCFA effectuée. Nouveau solde: " . number_format($client->fresh()->solde, 0, ',', ' ') . " FCFA"
        ];
    }

    /**
     * Envoyer une notification à un client
     */
    public static function sendNotification($clientId, $titre, $message)
    {
        return NotificationModel::create([
            'client_id' => $clientId,
            'titre' => $titre,
            'message' => $message,
            'lu' => false,
        ]);
    }

    /**
     * Modifier le solde d'un client
     */
    public static function updateSolde($clientId, $nouveauSolde)
    {
        $client = Client::find($clientId);
        
        if (!$client) {
            return ['error' => 'Client introuvable'];
        }

        $ancienSolde = $client->solde;
        $client->solde = $nouveauSolde;
        $client->save();

        return [
            'success' => true,
            'ancien_solde' => $ancienSolde,
            'nouveau_solde' => $nouveauSolde,
            'message' => "Solde modifié de " . number_format($ancienSolde, 0, ',', ' ') . " à " . number_format($nouveauSolde, 0, ',', ' ') . " FCFA"
        ];
    }
}