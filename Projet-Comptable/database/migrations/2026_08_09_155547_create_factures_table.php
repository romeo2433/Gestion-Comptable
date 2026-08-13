<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id('id_facture');
        
            $table->string('numero_facture', 50);
        
            $table->unsignedBigInteger('id_fournisseur');
            $table->unsignedBigInteger('id_compte_charge');
            $table->unsignedBigInteger('id_tva')->nullable();
        
            $table->date('date_facture');
            $table->date('date_echeance')->nullable();
        
            $table->decimal('montant_ht', 12, 2)->default(0);
            $table->decimal('montant_tva', 12, 2)->default(0);
            $table->decimal('montant_ttc', 12, 2)->default(0);
        
            $table->string('statut', 20)->default('En attente');
        
            $table->timestamps();
        
            $table->foreign('id_fournisseur')
                ->references('id_fournisseur')
                ->on('fournisseurs')
                ->onDelete('restrict');
        
            $table->foreign('id_compte_charge')
                ->references('id_compte')
                ->on('comptes')
                ->onDelete('restrict');
        
            $table->foreign('id_tva')
                ->references('id_tva')
                ->on('tva')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};