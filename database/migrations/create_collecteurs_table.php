<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('collecteurs', function (Blueprint $table) {
            $table->id('id_collect');
            $table->string('nom_collect')->nullable();
            $table->string('prenom_collect')->nullable();
            $table->string('tel_collect')->nullable();
            $table->string('zone_collect')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collecteurs');
    }
};
