<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'numero_recu',
        'nom_client',
        'type',
        'montant',
        'mode_paiement',
        'date_paiement',
        'statut',
        'description',
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'date_paiement' => 'date',
        'montant' => 'decimal:2',
    ];

    /**
     * Scope pour filtrer par type
     */
    public function scopeType(Builder $query, ?string $type): Builder
    {
        if ($type) {
            return $query->where('type', $type);
        }
        return $query;
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeStatut(Builder $query, ?string $statut): Builder
    {
        if ($statut) {
            return $query->where('statut', $statut);
        }
        return $query;
    }

    /**
     * Scope pour filtrer par période
     */
    public function scopePeriode(Builder $query, ?string $dateDebut, ?string $dateFin): Builder
    {
        if ($dateDebut) {
            $query->where('date_paiement', '>=', $dateDebut);
        }
        if ($dateFin) {
            $query->where('date_paiement', '<=', $dateFin);
        }
        return $query;
    }

    /**
     * Scope pour filtrer par montant
     */
    public function scopeMontant(Builder $query, ?float $montantMin, ?float $montantMax): Builder
    {
        if ($montantMin) {
            $query->where('montant', '>=', $montantMin);
        }
        if ($montantMax) {
            $query->where('montant', '<=', $montantMax);
        }
        return $query;
    }

    /**
     * Obtenir les statistiques des transactions
     */
    public static function obtenirStatistiques(?string $dateDebut = null, ?string $dateFin = null): array
    {
        $query = self::query();

        if ($dateDebut) {
            $query->where('date_paiement', '>=', $dateDebut);
        }
        if ($dateFin) {
            $query->where('date_paiement', '<=', $dateFin);
        }

        return [
            'total_transactions' => $query->count(),
            'total_encaissements' => (clone $query)->where('type', 'encaissement')->sum('montant'),
            'total_decaissements' => (clone $query)->where('type', 'decaissement')->sum('montant'),
            'solde' => (clone $query)->where('type', 'encaissement')->sum('montant') 
                     - (clone $query)->where('type', 'decaissement')->sum('montant'),
        ];
    }

    /**
     * Générer un numéro de reçu unique
     */
    public static function genererNumeroRecu(): string
    {
        $prefix = 'TRX';
        $date = now()->format('Ymd');
        $lastTransaction = self::whereDate('created_at', today())->latest()->first();
        
        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->numero_recu, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . '-' . $date . '-' . $newNumber;
    }
}
```
