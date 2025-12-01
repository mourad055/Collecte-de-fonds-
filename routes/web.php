<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clients',[ClientController::class,'index']);

Route::get('/check-backend', function () {
    try {
        \DB::connection()->getPdo();
        return "Backend + Database OK ✔";
    } catch (\Exception $e) {
        return "Erreur : " . $e->getMessage();
    }
});
