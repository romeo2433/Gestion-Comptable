<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AchatController;


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

    Route::view('/dashboard', 'dashboard.index')
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

        Route::view('/utilisateurs', 'utilisateurs.index')
            ->name('utilisateurs.index');

    });

});