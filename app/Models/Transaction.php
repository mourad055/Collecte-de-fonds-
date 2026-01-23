<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'numero_recu',
        'nom_client',
        'montant',
        'mode_paiement',
        'date_paiement'
    ];
}
