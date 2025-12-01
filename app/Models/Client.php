<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cli';
    protected $fillable = ['nom_cli','prenom_cli','tel_cli','adresse_cli','solde_cli'];

    public function paiements()
    {
        return $this->hasMany(Paiement::class,'id_cli','id_cli');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class,'id_cli','id_cli');
    }
}
