<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transact';
    protected $fillable = ['date_transact','montant_transact','id_cli','id_collect'];

    public function client()
    {
        return $this->belongsTo(Client::class,'id_cli','id_cli');
    }

    public function collecteur()
    {
        return $this->belongsTo(Collecteur::class,'id_collect','id_collect');
    }
}
