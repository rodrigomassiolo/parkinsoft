<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
    * Show the profile for the given user.
    *
    * @param  int  $id
    * @return View
    */

    public function post($func)
    {
        if($func){
            return 'jolanda Esto Es un Post a ña funcion '.$func;
        }else{
            return 'jolanda Esto Es un Post';
        }
        
    } 
}