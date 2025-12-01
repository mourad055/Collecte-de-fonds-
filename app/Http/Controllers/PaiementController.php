<?php
namespace App\Http\Controllers;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller {
    public function index(){ return Paiement::with('client')->get(); }
}