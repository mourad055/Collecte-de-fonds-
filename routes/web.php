<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('client.login');
});

// Routes publiques (sans authentification)
Route::get('/client/login', [ClientController::class, 'showLogin'])->name('client.login');
Route::post('/client/login', [ClientController::class, 'login']);

// Routes protégées (nécessitent l'authentification)
Route::middleware(['auth:client'])->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/client/solde', [ClientController::class, 'solde'])->name('client.solde');
    Route::get('/client/historique', [ClientController::class, 'historique'])->name('client.historique');
    Route::get('/client/notifications', [ClientController::class, 'notifications'])->name('client.notifications');
    Route::get('/client/profil', [ClientController::class, 'profil'])->name('client.profil');
    Route::post('/client/logout', [ClientController::class, 'logout'])->name('client.logout');
});