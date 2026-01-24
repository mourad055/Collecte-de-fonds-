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
        Schema::table('transactions', function (Blueprint $table) {
            // Champs de contrôle
            $table->boolean('est_controle')->default(false)->after('statut')->comment('Indique si la transaction a été contrôlée');
            $table->unsignedBigInteger('controleur_id')->nullable()->after('est_controle')->comment('ID de l\'utilisateur qui a fait le contrôle');
            $table->datetime('date_controle')->nullable()->after('controleur_id')->comment('Date et heure du contrôle');
            $table->text('note_controle')->nullable()->after('date_controle')->comment('Notes ou remarques du contrôleur');
            $table->enum('resultat_controle', ['valide', 'rejete', 'en_verification'])->nullable()->after('note_controle')->comment('Résultat du contrôle');
            
            // Index pour optimiser les recherches
            $table->index('est_controle');
            $table->index('resultat_controle');
            $table->index('date_controle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'est_controle',
                'controleur_id',
                'date_controle',
                'note_controle',
                'resultat_controle'
            ]);
        });
    }
};
```
