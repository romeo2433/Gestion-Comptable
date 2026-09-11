<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ligne_factures', function (Blueprint $table) {
            $table->id('id_ligne');

            $table->unsignedBigInteger('id_facture');

            $table->string('designation', 200);
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 12, 2);
            $table->decimal('montant', 12, 2);

            $table->timestamps();

            $table->foreign('id_facture')
                ->references('id_facture')
                ->on('factures')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ligne_factures');
    }
};