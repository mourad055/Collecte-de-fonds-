<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Collecteur;
use App\Models\Administrateur;

class DemoSeeder extends Seeder {
  public function run(){
    Client::factory()->count(5)->create();
    Collecteur::factory()->count(2)->create();
    Administrateur::create([
      'nom_admin'=>'Admin',
      'prenom_admin'=>'Root',
      'email_admin'=>'admin@test.com',
      'role_admin'=>'super',
      'password'=>bcrypt('password')
    ]);
  }
}