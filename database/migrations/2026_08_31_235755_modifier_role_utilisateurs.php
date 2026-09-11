<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->enum('role', [
                'admin',
                'caissier',
                'independant'
            ])->default('caissier')->change();
        });
    }

    public function down(): void
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->enum('role', [
                'admin',
                'caissier'
            ])->default('caissier')->change();
        });
    }
};