<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Model
{
    use HasFactory;

    // Votre clé primaire existante
    protected $primaryKey = 'id_transact';
    
    // Vos champs existants + nouveaux champs pour le contrôle
    protected $fillable = [
        'date_transact',
        'montant_transact',
        'id_cli',
        'id_collect',
        // NOUVEAUX CHAMPS POUR LE CONTRÔLE
        'est_controle',
        'controleur_id',
        'date_controle',
        'note_controle',
        'resultat_controle',
        'type_transact', // encaissement ou decaissement
        'statut_transact', // valide, en-attente, annule
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'date_transact' => 'date',
        'date_controle' => 'datetime',
        'montant_transact' => 'decimal:2',
        'est_controle' => 'boolean',
    ];

    // VOS RELATIONS EXISTANTES
    public function client()
    {
        return $this->belongsTo(Client::class, 'id_cli', 'id_cli');
    }

    public function collecteur()
    {
        return $this->belongsTo(Collecteur::class, 'id_collect', 'id_collect');
    }

    // NOUVEAUX SCOPES POUR LE CONTRÔLE

    /**
     * Scope pour les encaissements non contrôlés
     */
    public function scopeNonControle(Builder $query): Builder
    {
        return $query->where('type_transact', 'encaissement')
                     ->where('est_controle', false);
    }

    /**
     * Scope pour les encaissements contrôlés
     */
    public function scopeControle(Builder $query): Builder
    {
        return $query->where('type_transact', 'encaissement')
                     ->where('est_controle', true);
    }

    /**
     * Scope pour filtrer par type
     */
    public function scopeType(Builder $query, ?string $type): Builder
    {
        if ($type) {
            return $query->where('type_transact', $type);
        }
        return $query;
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeStatut(Builder $query, ?string $statut): Builder
    {
        if ($statut) {
            return $query->where('statut_transact', $statut);
        }
        return $query;
    }

    /**
     * Scope pour filtrer par période
     */
    public function scopePeriode(Builder $query, ?string $dateDebut, ?string $dateFin): Builder
    {
        if ($dateDebut) {
            $query->where('date_transact', '>=', $dateDebut);
        }
        if ($dateFin) {
            $query->where('date_transact', '<=', $dateFin);
        }
        return $query;
    }

    /**
     * Scope pour filtrer par montant
     */
    public function scopeMontant(Builder $query, ?float $montantMin, ?float $montantMax): Builder
    {
        if ($montantMin) {
            $query->where('montant_transact', '>=', $montantMin);
        }
        if ($montantMax) {
            $query->where('montant_transact', '<=', $montantMax);
        }
        return $query;
    }

    /**
     * Obtenir les statistiques de contrôle des encaissements
     */
    public static function obtenirStatistiquesControle(?string $dateDebut = null, ?string $dateFin = null): array
    {
        $query = self::where('type_transact', 'encaissement');

        if ($dateDebut) {
            $query->where('date_transact', '>=', $dateDebut);
        }
        if ($dateFin) {
            $query->where('date_transact', '<=', $dateFin);
        }

        return [
            'total_encaissements' => (clone $query)->count(),
            'encaissements_controles' => (clone $query)->where('est_controle', true)->count(),
            'encaissements_non_controles' => (clone $query)->where('est_controle', false)->count(),
            'encaissements_valides' => (clone $query)->where('resultat_controle', 'valide')->count(),
            'encaissements_rejetes' => (clone $query)->where('resultat_controle', 'rejete')->count(),
            'montant_total' => (clone $query)->sum('montant_transact'),
            'montant_controle' => (clone $query)->where('est_controle', true)->sum('montant_transact'),
            'montant_non_controle' => (clone $query)->where('est_controle', false)->sum('montant_transact'),
        ];
    }

    /**
     * Marquer comme contrôlé
     */
    public function marquerControle(string $resultat, ?string $note = null, ?int $controleurId = null): bool
    {
        $this->est_controle = true;
        $this->resultat_controle = $resultat;
        $this->note_controle = $note;
        $this->controleur_id = $controleurId;
        $this->date_controle = now();

        // Si le contrôle est rejeté, on change aussi le statut
        if ($resultat === 'rejete') {
            $this->statut_transact = 'annule';
        } elseif ($resultat === 'valide') {
            $this->statut_transact = 'valide';
        }

        return $this->save();
    }
}
