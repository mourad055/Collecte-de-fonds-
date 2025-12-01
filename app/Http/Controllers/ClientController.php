<?php
namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller {
    public function index(){ return Client::all(); }
    public function store(Request $r){ return Client::create($r->all()); }
}