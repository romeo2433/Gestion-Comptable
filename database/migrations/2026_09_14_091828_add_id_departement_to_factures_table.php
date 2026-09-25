<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->unsignedBigInteger('id_departement')
                ->nullable()
                ->after('id_utilisateur');

            $table->foreign('id_departement')
                ->references('id_departement')
                ->on('departements')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->dropForeign(['id_departement']);
            $table->dropColumn('id_departement');
        });
    }
};