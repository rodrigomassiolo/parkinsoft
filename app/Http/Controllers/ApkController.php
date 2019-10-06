<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApkController extends Controller
{
    public function download()
    {
        return response()->file(storage_path('app')."parkinsoft.apk");
    }
}
