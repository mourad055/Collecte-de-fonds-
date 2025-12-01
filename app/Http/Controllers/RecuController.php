<?php
namespace App\Http\Controllers;
use App\Models\Recu;

class RecuController extends Controller {
    public function index(){ return Recu::with('paiement')->get(); }
}