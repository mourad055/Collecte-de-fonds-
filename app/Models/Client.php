<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'password',
        'solde',
        'derniere_connexion',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'derniere_connexion' => 'datetime',
        'solde' => 'decimal:2',
    ];

    // Relations
    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('created_at', 'desc');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }
}