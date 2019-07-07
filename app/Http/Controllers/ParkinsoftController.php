<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ParkinsonController extends Controller
{
    public function index()
    {
        return 'jolanda';
    } 
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    
    public function show($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
}