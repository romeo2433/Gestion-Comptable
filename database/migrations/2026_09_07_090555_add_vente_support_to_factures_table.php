<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('factures', function (Blueprint $table) {

            // Type de facture : achat ou vente
            $table->enum('type', ['achat', 'vente'])
                ->default('achat')
                ->after('id_facture');

            // Client pour une facture de vente
            $table->foreignId('id_client')
                ->nullable()
                ->after('id_fournisseur')
                ->constrained('clients', 'id_client')
                ->nullOnDelete();

            // Compte produit pour une facture de vente
            $table->foreignId('id_compte_produit')
                ->nullable()
                ->after('id_compte_charge')
                ->constrained('comptes', 'id_compte')
                ->nullOnDelete();
        });

        // Un achat possède un fournisseur,
        // mais une vente n'en possède pas.
        Schema::table('factures', function (Blueprint $table) {
            $table->unsignedBigInteger('id_fournisseur')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('factures', function (Blueprint $table) {

            $table->dropForeign(['id_compte_produit']);
            $table->dropColumn('id_compte_produit');

            $table->dropForeign(['id_client']);
            $table->dropColumn('id_client');

            $table->dropColumn('type');

            $table->unsignedBigInteger('id_fournisseur')
                ->nullable(false)
                ->change();
        });
    }
};