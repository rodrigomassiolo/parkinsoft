<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function infosite(){
        return view('info.infosite');
    }

    public function infoproj(){
        return view('info.infoproj');
    }
}