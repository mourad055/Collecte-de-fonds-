<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collecteur extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_collect';
    protected $fillable = ['nom_collect','prenom_collect','tel_collect','zone_collect'];

    public function paiements()
    {
        return $this->hasMany(Paiement::class,'id_collect','id_collect');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class,'id_collect','id_collect');
    }
}
