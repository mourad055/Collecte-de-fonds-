<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Ajouter le type de transaction si pas déjà présent
            if (!Schema::hasColumn('transactions', 'type_transact')) {
                $table->enum('type_transact', ['encaissement', 'decaissement'])->default('encaissement')->after('montant_transact');
            }
            
            // Ajouter le statut si pas déjà présent
            if (!Schema::hasColumn('transactions', 'statut_transact')) {
                $table->enum('statut_transact', ['valide', 'en-attente', 'annule'])->default('valide')->after('type_transact');
            }
            
            // Champs de contrôle
            $table->boolean('est_controle')->default(false)->after('statut_transact');
            $table->unsignedBigInteger('controleur_id')->nullable()->after('est_controle');
            $table->datetime('date_controle')->nullable()->after('controleur_id');
            $table->text('note_controle')->nullable()->after('date_controle');
            $table->enum('resultat_controle', ['valide', 'rejete', 'en_verification'])->nullable()->after('note_controle');
            
            // Index
            $table->index('est_controle');
            $table->index('resultat_controle');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'est_controle',
                'controleur_id',
                'date_controle',
                'note_controle',
                'resultat_controle',
                'type_transact',
                'statut_transact'
            ]);
        });
    }
};
