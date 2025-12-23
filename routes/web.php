<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//route page accueil
Route::get('/', function () {
    return view('welcome');
});


//route page paiement
Route::get('/paiement', function () {
    return view('paiement.paiement');
})->name('paiement');

Route::post('/paiement', function () {
    // logique de paiement ici
    // ex: validation, enregistrement, génération du reçu
})->name('paiement.store');

//route generé recu
Route::post('/paiement', function (\Illuminate\Http\Request $request) {

    // Génération du numéro de reçu
    $numero_recu = 'RCU-' . date('Ymd') . '-' . rand(1000, 9999);

    return view('recu.generate', [
        'numero_recu'   => $numero_recu,
        'nom'           => $request->nom,
        'reference'     => $request->reference,
        'montant'       => $request->montant,
        'mode_paiement' => $request->mode_paiement,
        'date_paiement' => $request->date_paiement,
    ]);

})->name('paiement.generate');



Route::post('/recu/pdf', function (Request $request) {

    // Pour l’instant, on teste juste
    return view('recu.generate', [
        'numero_recu'   => 'RCU-' . date('Ymd') . '-' . rand(1000, 9999),
        'nom'           => $request->nom,
        'reference'     => $request->reference,
        'montant'       => $request->montant,
        'mode_paiement' => $request->mode_paiement,
        'date_paiement' => $request->date_paiement,
    ]);

})->name('recu.pdf');


//route page login avec authentification
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/collecteur/dashboard', function () {
        return view('collecteur.dashboard');
    })->name('collecteur.dashboard');

    Route::get('/client/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');
});

Route::get('/clients/create', [ClientController::class, 'create'])
    ->name('clients.create');

// Enregistrer un client (après clic sur "Enregistrer")
Route::post('/clients', [ClientController::class, 'store'])
    ->name('clients.store');

// Afficher la liste des clients
Route::get('/clients', [ClientController::class, 'index'])
    ->name('clients.index');

// Afficher le formulaire de modification
Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])
    ->name('clients.edit');

// Mettre à jour un client
Route::put('/clients/{id}', [ClientController::class, 'update'])
    ->name('clients.update');

// Supprimer un client
Route::delete('/clients/{id}', [ClientController::class, 'destroy'])
    ->name('clients.destroy');

// Route resource pour les clients
Route::resource('clients', ClientController::class);



Route::get('/check-backend', function () {
    try {
        \DB::connection()->getPdo();
        return "Backend + Database OK ✔";
    } catch (\Exception $e) {
        return "Erreur : " . $e->getMessage();
    }
});
