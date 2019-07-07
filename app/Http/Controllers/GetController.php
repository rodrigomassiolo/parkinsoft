<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class GetController extends Controller
{
    /**
    * Show the profile for the given user.
    *
    * @param  int  $id
    * @return View
    */

    public function get($key,$value)
    {
        if($key && $value){
            return 'jolanda Esto Es un Get a la funcion '.$key.'  '.$value;
        }else{
            return 'jolanda Esto Es un get sin funcion';
        }
        
    } 

    public function login()
    {
        return view('signin');
    } 
    public function dash()
    {
        return view('dash');
    } 

}