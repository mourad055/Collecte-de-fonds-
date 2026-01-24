<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('numero_recu')->unique()->comment('Numéro unique du reçu');
            $table->string('nom_client')->comment('Nom du client');
            $table->enum('type', ['encaissement', 'decaissement'])->default('encaissement')->comment('Type de transaction');
            $table->decimal('montant', 15, 2)->comment('Montant de la transaction');
            $table->string('mode_paiement')->comment('Mode de paiement: espèces, carte, virement, mobile money, etc.');
            $table->date('date_paiement')->comment('Date du paiement');
            $table->enum('statut', ['valide', 'en-attente', 'annule'])->default('valide')->comment('Statut de la transaction');
            $table->text('description')->nullable()->comment('Description ou remarques');
            $table->timestamps();
            
            // Index pour optimiser les recherches
            $table->index('date_paiement');
            $table->index('type');
            $table->index('statut');
            $table->index('mode_paiement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
