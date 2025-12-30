<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CollecteurController;
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




Route::get('/paiement', [PaiementController::class, 'create'])->name('paiement');
Route::post('/paiement', [PaiementController::class, 'store'])->name('paiement.store');
// (optionnel - pour une page listant les paiements)
Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');

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

    // Routes Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Gestion des collecteurs
        Route::get('/collecteurs', [AdminController::class, 'collecteurs'])->name('collecteurs');
        Route::get('/collecteurs/create', [AdminController::class, 'createCollecteur'])->name('collecteurs.create');
        Route::post('/collecteurs', [AdminController::class, 'storeCollecteur'])->name('collecteurs.store');
        Route::get('/collecteurs/{id}/edit', [AdminController::class, 'editCollecteur'])->name('collecteurs.edit');
        Route::put('/collecteurs/{id}', [AdminController::class, 'updateCollecteur'])->name('collecteurs.update');
        Route::delete('/collecteurs/{id}', [AdminController::class, 'destroyCollecteur'])->name('collecteurs.destroy');
        
        // Gestion des clients
        Route::get('/clients', [AdminController::class, 'clients'])->name('clients');
        Route::get('/clients/create', [AdminController::class, 'createClient'])->name('clients.create');
        Route::post('/clients', [AdminController::class, 'storeClient'])->name('clients.store');
        Route::get('/clients/{id}/edit', [AdminController::class, 'editClient'])->name('clients.edit');
        Route::put('/clients/{id}', [AdminController::class, 'updateClient'])->name('clients.update');
        Route::delete('/clients/{id}', [AdminController::class, 'destroyClient'])->name('clients.destroy');
        
        // Transactions
        Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
        
        // Encaissements
        Route::get('/encaissements', [AdminController::class, 'encaissements'])->name('encaissements');
        Route::post('/encaissements/{id}/valider', [AdminController::class, 'validerPaiement'])->name('encaissements.valider');
        Route::post('/encaissements/{id}/rejeter', [AdminController::class, 'rejeterPaiement'])->name('encaissements.rejeter');
        
        // Rapports
        Route::get('/rapport/financier', [AdminController::class, 'exportRapportFinancier'])->name('rapport.financier');
        Route::get('/statistiques', [AdminController::class, 'exportStatistiques'])->name('statistiques');
    });

    Route::get('/collecteur/dashboard', [CollecteurController::class, 'dashboard'])->name('collecteur.dashboard');

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

Route::middleware(['auth'])->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])
        ->name('client.dashboard');
});



Route::get('/check-backend', function () {
    try {
        \DB::connection()->getPdo();
        return "Backend + Database OK ✔";
    } catch (\Exception $e) {
        return "Erreur : " . $e->getMessage();
    }
});
