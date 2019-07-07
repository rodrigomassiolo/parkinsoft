<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //lo agrega para poder filtrar solo la data del usuario y hacer el where

class ClientController extends Controller
{
    public function index()
    {
        //$clients = \App\Client::all(); -->no le puedo mostrar todo
        $clients = \App\Client::where('user_id', Auth::user()->id)->get();
        return view('client', compact('clients'));
    }
    
}
