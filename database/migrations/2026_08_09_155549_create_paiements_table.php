<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id('id_paiement');

            $table->unsignedBigInteger('id_facture');

            $table->date('date_paiement');
            $table->decimal('montant', 12, 2);
            $table->string('mode_paiement', 50);

            $table->timestamps();

            $table->foreign('id_facture')
                ->references('id_facture')
                ->on('factures')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};