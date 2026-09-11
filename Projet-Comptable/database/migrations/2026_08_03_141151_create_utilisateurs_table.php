<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id('id_utilisateur');
            $table->string('nom', 150);
            $table->string('email', 100)->unique();
            $table->string('mot_de_passe');
            $table->enum('role', ['admin', 'caissier']);
            $table->timestamps();
        });
    
        DB::table('utilisateurs')->insert([
            [
                'nom' => 'Administrateur',
                'email' => 'admin@facture.com',
                'mot_de_passe' =>'admin123',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Jean Rakoto',
                'email' => 'jean@facture.com',
                'mot_de_passe' => 'caissier123',
                'role' => 'caissier',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Marie Rabe',
                'email' => 'marie@facture.com',
                'mot_de_passe' => 'caissier456',
                'role' => 'caissier',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};