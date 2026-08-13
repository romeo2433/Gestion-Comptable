<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AchatController;


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
| Tableau de bord
|--------------------------------------------------------------------------
*/

Route::view('/dashboard', 'dashboard.index')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Clients
|--------------------------------------------------------------------------
*/

Route::view('/achats', 'achats.index')
    ->name('achats.index');

/*
|--------------------------------------------------------------------------
| Factures
|--------------------------------------------------------------------------
*/

Route::view('/factures', 'factures.index')
    ->name('factures.index');

/*
|--------------------------------------------------------------------------
| Paiements
|--------------------------------------------------------------------------
*/

Route::view('/paiements', 'paiements.index')
    ->name('paiements.index');

/*
|--------------------------------------------------------------------------
| Utilisateurs
|--------------------------------------------------------------------------
*/

Route::view('/utilisateurs', 'utilisateurs.index')
    ->name('utilisateurs.index');


Route::get('/achats', [AchatController::class, 'index'])
    ->name('achats.index');

Route::post('/achats/upload', [AchatController::class, 'upload'])
    ->name('achats.upload');