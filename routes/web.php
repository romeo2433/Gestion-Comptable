<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AchatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\UtilisateurController;


/*
|--------------------------------------------------------------------------
| Accueil
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('login.post');

Route::get('/register', [AuthController::class, 'register'])
    ->name('register');

Route::post('/register', [AuthController::class, 'store'])
    ->name('register.store');

Route::get('/entreprise/create', [EntrepriseController::class, 'create'])
    ->name('entreprise.create');

Route::post('/entreprise', [EntrepriseController::class, 'store'])
    ->name('entreprise.store');

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| UTILISATEURS CONNECTÉS
|--------------------------------------------------------------------------
*/

Route::middleware('check.auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Tableau de bord
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ACHATS
    |--------------------------------------------------------------------------
    */

    Route::get('/achats', [AchatController::class, 'index'])
        ->name('achats.index');

    Route::post('/achats/upload', [AchatController::class, 'upload'])
        ->name('achats.upload');

    Route::get('/achats/{id}', [AchatController::class, 'show'])
        ->name('achats.show');

    Route::get('/facture/preview/{id}', [AchatController::class, 'preview'])
        ->name('facture.preview');

    Route::put('/achats/{id}/paiement', [AchatController::class, 'updatePaiement'])
        ->name('achats.paiement.update');

    Route::delete('/achats/{id}', [AchatController::class, 'destroy'])
        ->name('achats.destroy');


    /*
    |--------------------------------------------------------------------------
    | VENTES
    |--------------------------------------------------------------------------
    */

    Route::get('/ventes', [VenteController::class, 'index'])
        ->name('ventes.index');

    Route::post('/ventes/upload', [VenteController::class, 'upload'])
        ->name('ventes.upload');

    Route::get('/ventes/{id}/preview', [VenteController::class, 'preview'])
        ->name('ventes.preview');

    Route::get('/ventes/{id}', [VenteController::class, 'show'])
        ->name('ventes.show');

    Route::put('/ventes/{id}/paiement', [VenteController::class, 'updatePaiement'])
        ->name('ventes.paiement.update');

    Route::delete('/ventes/{id}', [VenteController::class, 'destroy'])
        ->name('ventes.destroy');

    

    // =====================================================
    // ENTREPRISE
    // =====================================================

    Route::get('/entreprise/create', [EntrepriseController::class, 'create'])
    ->name('entreprises.create');

    Route::post('/entreprise', [EntrepriseController::class, 'store'])
    ->name('entreprises.store');

    Route::get('/entreprise/edit', [EntrepriseController::class, 'edit'])
    ->name('entreprises.edit');

    Route::put('/entreprise', [EntrepriseController::class, 'update'])
    ->name('entreprises.update');


    /*
    |--------------------------------------------------------------------------
    | FACTURES
    |--------------------------------------------------------------------------
    */

    Route::view('/factures', 'factures.index')
        ->name('factures.index');


    /*
    |--------------------------------------------------------------------------
    | PAIEMENTS
    |--------------------------------------------------------------------------
    */

    Route::view('/paiements', 'paiements.index')
        ->name('paiements.index');


    /*
    |--------------------------------------------------------------------------
    | ADMIN UNIQUEMENT
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Gestion des utilisateurs
        |--------------------------------------------------------------------------
        */
    
        Route::get('/utilisateurs', [UtilisateurController::class, 'index'])
            ->name('utilisateurs.index');
    
        Route::get('/utilisateurs/create', [UtilisateurController::class, 'create'])
            ->name('utilisateurs.create');
    
        Route::post('/utilisateurs', [UtilisateurController::class, 'store'])
            ->name('utilisateurs.store');
    
        Route::get('/utilisateurs/{id}/edit', [UtilisateurController::class, 'edit'])
            ->name('utilisateurs.edit');
    
        Route::put('/utilisateurs/{id}', [UtilisateurController::class, 'update'])
            ->name('utilisateurs.update');
    
        Route::patch('/utilisateurs/{id}/statut', [UtilisateurController::class, 'toggleStatut'])
            ->name('utilisateurs.toggleStatut');
    
        Route::delete('/utilisateurs/{id}', [UtilisateurController::class, 'destroy'])
            ->name('utilisateurs.destroy');
    
    });

});