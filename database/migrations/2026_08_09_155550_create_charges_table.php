<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id('id_charge');

            $table->unsignedBigInteger('id_compte');
            $table->unsignedBigInteger('id_fournisseur');

            $table->date('date_charge');
            $table->decimal('montant', 12, 2);
            $table->text('description')->nullable();

            $table->timestamps();

            $table->foreign('id_compte')
                ->references('id_compte')
                ->on('comptes')
                ->onDelete('restrict');

            $table->foreign('id_fournisseur')
                ->references('id_fournisseur')
                ->on('fournisseurs')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};