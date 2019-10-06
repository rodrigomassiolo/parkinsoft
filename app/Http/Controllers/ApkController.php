<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApkController extends Controller
{
    public function download()
    {

    //PDF file is stored under project/public/download/info.pdf
    $file= storage_path('app')."/Parkinsoft.apk";

    $headers = array(
              'Content-Type: application/vnd.android.package-archive',
            );

    return Response::download($file, 'Parkinsoft.apk', $headers);

    }
}
