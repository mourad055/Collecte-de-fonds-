<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Administrateur;

class AdministrateurController extends Controller {
    public function index(){ return Administrateur::all(); }
}