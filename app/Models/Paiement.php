<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_paie';
    protected $fillable = ['montant_paie','date_paie','id_cli','id_collect','statut_paie'];

    public function client()
    {
        return $this->belongsTo(Client::class,'id_cli','id_cli');
    }

    public function collecteur()
    {
        return $this->belongsTo(Collecteur::class,'id_collect','id_collect');
    }

    public function recu()
    {
        return $this->hasOne(Recu::class,'id_paie','id_paie');
    }
}
