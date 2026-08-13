<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tva', function (Blueprint $table) {
            $table->unsignedBigInteger('id_compte')->nullable()->after('type_tva');

            $table->foreign('id_compte')
                ->references('id_compte')
                ->on('comptes')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tva', function (Blueprint $table) {
            $table->dropForeign(['id_compte']);
            $table->dropColumn('id_compte');
        });
    }
};