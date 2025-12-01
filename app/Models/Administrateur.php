<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Administrateur extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_admin';
    protected $fillable = ['nom_admin','prenom_admin','email_admin','role_admin','password'];
    protected $hidden = ['password'];
}
