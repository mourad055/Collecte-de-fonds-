<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('administrateurs', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('nom_admin')->nullable();
            $table->string('prenom_admin')->nullable();
            $table->string('email_admin')->unique();
            $table->string('role_admin')->nullable();
            $table->string('password'); // si tu veux se connecter via ce compte
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administrateurs');
    }
};
