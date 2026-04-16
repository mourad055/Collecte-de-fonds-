<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('id_transact');
            $table->dateTime('date_transact')->nullable();
            $table->decimal('montant_transact', 12, 2);
            $table->unsignedBigInteger('id_cli');
            $table->unsignedBigInteger('id_collect')->nullable();
            $table->timestamps();

            $table->foreign('id_cli')->references('id_cli')->on('clients')->onDelete('cascade');
            $table->foreign('id_collect')->references('id_collect')->on('collecteurs')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};


