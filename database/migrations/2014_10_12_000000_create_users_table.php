<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('numero_recu')->unique();
            $table->string('nom_client');
            $table->enum('type', ['encaissement', 'decaissement']); // AJOUT
            $table->decimal('montant', 15, 2); // Augmenté à 15 pour les gros montants
            $table->string('mode_paiement'); // espèces, carte, virement, etc.
            $table->date('date_paiement');
            $table->enum('statut', ['valide', 'en-attente', 'annule'])->default('valide'); // AJOUT
            $table->text('description')->nullable(); // AJOUT
            $table->timestamps();
            
            // Index pour optimiser les recherches
            $table->index('date_paiement');
            $table->index('type');
            $table->index('statut');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
```
