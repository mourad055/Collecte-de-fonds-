<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    // Indique explicitement le nom de la table si c'est différent de "paiements"
    // protected $table = 'paiement'; // Décommente ceci si le nom de la table est `paiement`

    // Indique la clé primaire réelle si elle n'est pas "id"
    protected $primaryKey = 'id_paie';
    public $incrementing = true; // Assurez-vous que la clé primaire s'auto-incrémente
    protected $keyType = 'int'; // Ou 'string' selon votre colonne

    // Les champs à remplir
    protected $fillable = [
        'montant_paie',
        'date_paie',
        'id_cli',      // Clé étrangère vers la table clients
        'id_collect',  // Clé étrangère vers la table collecteurs
        'statut_paie'
    ];

    // Si la table n'a PAS de timestamps (created_at, updated_at), désactivez-les :
    public $timestamps = false;

    /**
     * Relation avec le client.
     * Attention : 
     *  - Le modèle Client doit exister dans App\Models\Client.
     *  - Vérifiez que la clé primaire de la table clients est bien 'id_cli'.
     */
    public function client()
    {
        // belongsTo(Model, foreign_key_in_this_table, primary_key_in_related)
        // foreign_key_in_this_table = 'id_cli' dans PAIE, primary_key_in_related = 'id_cli' dans CLIENT
        return $this->belongsTo(Client::class, 'id_cli', 'id_cli');
    }

    /**
     * Relation avec le collecteur.
     */
    public function collecteur()
    {
        return $this->belongsTo(Collecteur::class, 'id_collect', 'id_collect');
    }

    /**
     * Relation avec le reçu.
     */
    public function recu()
    {
        return $this->hasOne(Recu::class, 'id_paie', 'id_paie');
    }
}

// ==== Indications utiles ====
//
// 1. Pour que les noms des clients s'affichent dans Blade :
//     - Le modèle Client doit exister et le champ du nom doit être correctement défini (ex : "nom" ou "name").
//     - Vérifiez dans la base de données si le champ existe bien et si les données sont présentes.
//     - Dans votre blade, utilisez : $paiement->client->nom  (ou ->name selon le champ réel).
//
// 2. Si aucun client ne s'affiche, il faut :
//     - Vérifier que la relation (clé étrangère id_cli) est correcte dans la table paiements.
//     - Vérifier la table clients : la clé primaire doit être 'id_cli'.
//
// 3. Pour déboguer : utilisez @dd($clients) ou @dd($paiement->client) dans vos blades.
//
// 4. Si vous utilisez une table avec un nom au singulier ("paiement" pas "paiements"):
//     - Décommentez la ligne protected $table = 'paiement'; ci-dessus.
//
/* Exemple d'accès dans le controller ou la vue :
    $paiement = Paiement::with('client')->first();
    echo $paiement->client ? $paiement->client->nom : '';
*/
