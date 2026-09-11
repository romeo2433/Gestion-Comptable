<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entreprises', function (Blueprint $table) {

            $table->id('id_entreprise');

            // Utilisateur propriétaire
            $table->unsignedBigInteger('id_utilisateur');

            // Informations générales
            $table->string('nom');
            $table->string('nom_commercial')->nullable();
            $table->string('forme_juridique')->nullable();
            $table->string('secteur_activite')->nullable();
            $table->date('date_creation')->nullable();

            // Coordonnées
            $table->text('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('site_web')->nullable();

            // Informations légales
            $table->string('nif')->nullable();
            $table->string('stat')->nullable();
            $table->string('rcs')->nullable();

            // Informations bancaires
            $table->string('nom_banque')->nullable();
            $table->string('numero_compte')->nullable();
            $table->string('titulaire_compte')->nullable();

            $table->timestamps();

            // Relation avec utilisateurs
            $table->foreign('id_utilisateur')
                  ->references('id_utilisateur')
                  ->on('utilisateurs')
                  ->onDelete('cascade');

            // Un utilisateur = une entreprise
            $table->unique('id_utilisateur');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};