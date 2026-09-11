<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ecritures', function (Blueprint $table) {
            $table->id('id_ecriture');
        
            $table->unsignedBigInteger('id_journal');
            $table->unsignedBigInteger('id_compte');
        
            $table->decimal('debit', 12, 2)->default(0);
            $table->decimal('credit', 12, 2)->default(0);
        
            $table->timestamps();
        
            $table->foreign('id_journal')
                ->references('id_journal')
                ->on('journal')
                ->onDelete('cascade');
        
            $table->foreign('id_compte')
                ->references('id_compte')
                ->on('comptes')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ecritures');
    }
};