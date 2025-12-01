<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('id_cli');
            $table->string('nom_cli');
            $table->string('prenom_cli')->nullable();
            $table->string('tel_cli')->nullable();
            $table->string('adresse_cli')->nullable();
            $table->decimal('solde_cli', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
