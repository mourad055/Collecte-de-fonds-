<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id('id_paie');
            $table->decimal('montant_paie', 12, 2);
            $table->dateTime('date_paie')->nullable();
            $table->unsignedBigInteger('id_cli');
            $table->unsignedBigInteger('id_collect')->nullable();
            $table->string('statut_paie')->default('en_attente');
            $table->timestamps();

            $table->foreign('id_cli')->references('id_cli')->on('clients')->onDelete('cascade');
            $table->foreign('id_collect')->references('id_collect')->on('collecteurs')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
