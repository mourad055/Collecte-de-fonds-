<?php
namespace App\Http\Controllers;
use App\Models\Collecteur;
use Illuminate\Http\Request;

class CollecteurController extends Controller {
    public function index(){ return Collecteur::all(); }
}