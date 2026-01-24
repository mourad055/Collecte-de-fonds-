<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un client de test
        $client = Client::create([
            'nom' => 'Doe',
            'prenom' => 'John',
            'telephone' => '694567890',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password123'),
            'solde' => 10150000,
        ]);

        // Créer des transactions de test
        Transaction::create([
            'client_id' => $client->id,
            'type' => 'depot',
            'montant' => 50000,
            'description' => 'Dépôt initial',
            'reference' => 'DEP-' . time() . '-1',
        ]);

        Transaction::create([
            'client_id' => $client->id,
            'type' => 'depot',
            'montant' => 100000,
            'description' => 'Dépôt mensuel',
            'reference' => 'DEP-' . time() . '-2',
        ]);

        Transaction::create([
            'client_id' => $client->id,
            'type' => 'retrait',
            'montant' => 25000,
            'description' => 'Retrait guichet',
            'reference' => 'RET-' . time() . '-1',
        ]);


        Transaction::create([
            'client_id' => $client->id,
            'type' => 'depot',
            'montant' => 10000000,
            'description' => 'Dépôt mensuel',
            'reference' => 'DEP-' . time() . '-3',
        ]);

        // Créer des notifications de test
        Notification::create([
            'client_id' => $client->id,
            'titre' => 'Bienvenue',
            'message' => 'Bienvenue sur votre espace client. Vous pouvez consulter votre solde et historique.',
            'lu' => false,
        ]);

        Notification::create([
            'client_id' => $client->id,
            'titre' => 'Nouveau dépôt',
            'message' => 'Un dépôt de 100,000 FCFA a été effectué sur votre compte.',
            'lu' => false,
        ]);

        Notification::create([
            'client_id' => $client->id,
            'titre' => 'Retrait effectué',
            'message' => 'Un retrait de 25,000 FCFA a été effectué.',
            'lu' => true,
        ]);


        Notification::create([
            'client_id' => $client->id,
            'titre' => 'Nouveau dépôt',
            'message' => 'Un dépôt de 10.000.000 FCFA a été effectué sur votre compte.',
            'lu' => false,
        ]);

    }
}