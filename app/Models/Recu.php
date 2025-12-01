<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recu extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_recu';
    protected $fillable = ['dateCreation_recu','montant_recu','id_paie'];

    public function paiement()
    {
        return $this->belongsTo(Paiement::class,'id_paie','id_paie');
    }
}
