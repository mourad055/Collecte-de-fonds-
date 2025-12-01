<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recus', function (Blueprint $table) {
            $table->id('id_recu');
            $table->dateTime('dateCreation_recu')->nullable();
            $table->decimal('montant_recu', 12, 2);
            $table->unsignedBigInteger('id_paie');
            $table->timestamps();

            $table->foreign('id_paie')->references('id_paie')->on('paiements')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recus');
    }
};
