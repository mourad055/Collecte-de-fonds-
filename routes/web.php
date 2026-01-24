<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\CollecteurController;
use App\Http\Controllers\ChatAssistantController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\EncaissementController;

/*
|--------------------------------------------------------------------------
| Pages publiques
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/fonctionnement', 'fonctionnement')->name('fonctionnement');
Route::view('/contact', 'contact')->name('contact');

/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/
Route::get('/login', fn () => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Paiements & Reçus
|--------------------------------------------------------------------------
*/
Route::get('/paiement', [PaiementController::class, 'create'])->name('paiement');
Route::post('/paiement', [PaiementController::class, 'store'])->name('paiement.store');
Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');

Route::post('/recu/pdf', function (Request $request) {
    return view('recu.generate', [
        'numero_recu'   => 'RCU-' . date('Ymd') . '-' . rand(1000, 9999),
        'nom'           => $request->nom,
        'reference'     => $request->reference,
        'montant'       => $request->montant,
        'mode_paiement' => $request->mode_paiement,
        'date_paiement' => $request->date_paiement,
    ]);
})->name('recu.pdf');

/*
|--------------------------------------------------------------------------
| Routes protégées (auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard Admin
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Collecteurs
        Route::resource('collecteurs', CollecteurController::class);

        // Clients
        Route::resource('clients', ClientController::class);

        // Transactions & Encaissements (vue admin)
        Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
        Route::get('/encaissements', [AdminController::class, 'encaissements'])->name('encaissements');

        Route::post('/encaissements/{id}/valider', [AdminController::class, 'validerPaiement'])
            ->name('encaissements.valider');

        Route::post('/encaissements/{id}/rejeter', [AdminController::class, 'rejeterPaiement'])
            ->name('encaissements.rejeter');

        // Rapports
        Route::get('/rapport/financier', [AdminController::class, 'exportRapportFinancier'])
            ->name('rapport.financier');

        Route::get('/statistiques', [AdminController::class, 'exportStatistiques'])
            ->name('statistiques');

        // Administrateurs
        Route::resource('admins', AdminController::class)->only(['index', 'create', 'store']);
    });

    /*
    |--------------------------------------------------------------------------
    | Dashboards
    |--------------------------------------------------------------------------
    */
    Route::get('/collecteur/dashboard', [CollecteurController::class, 'dashboard'])
        ->name('collecteur.dashboard');

    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])
        ->name('client.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Assistant IA
    |--------------------------------------------------------------------------
    */
    Route::post('/assistant/chat', [ChatAssistantController::class, 'ask'])
        ->name('assistant.chat');
});

/*
|--------------------------------------------------------------------------
| Transactions
|--------------------------------------------------------------------------
*/
Route::resource('transactions', TransactionController::class);
Route::get('transactions-export', [TransactionController::class, 'export'])
    ->name('transactions.export');

/*
|--------------------------------------------------------------------------
| Encaissements (logique métier)
|--------------------------------------------------------------------------
*/
Route::prefix('encaissements')->name('encaissements.')->group(function () {

    Route::get('controle', [EncaissementController::class, 'index'])->name('controle');
    Route::get('{id}', [EncaissementController::class, 'show'])->name('show');

    Route::post('{id}/valider', [EncaissementController::class, 'valider'])->name('valider');
    Route::post('{id}/rejeter', [EncaissementController::class, 'rejeter'])->name('rejeter');
    Route::post('{id}/en-verification', [EncaissementController::class, 'enVerification'])
        ->name('en-verification');

    Route::post('{id}/annuler-controle', [EncaissementController::class, 'annulerControle'])
        ->name('annuler-controle');

    Route::post('valider-en-masse', [EncaissementController::class, 'validerEnMasse'])
        ->name('valider-en-masse');

    Route::get('exporter-rapport', [EncaissementController::class, 'exporterRapport'])
        ->name('exporter-rapport');

    Route::get('rapport-synthese', [EncaissementController::class, 'rapportSynthese'])
        ->name('rapport-synthese');
});

/*
|--------------------------------------------------------------------------
| Test Backend
|--------------------------------------------------------------------------
*/
Route::get('/check-backend', function () {
    try {
        \DB::connection()->getPdo();
        return "Backend + Database OK ✔";
    } catch (\Exception $e) {
        return "Erreur : " . $e->getMessage();
    }
});
