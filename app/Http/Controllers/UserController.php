<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserFormRequest;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function update(UserFormRequest $request){

        $actualUser = $request->get('email');

        $user0 = User::where([
            ['email', '=', $actualUser],
        ])->first();

        $user0->genero = $request->get('genero');
        $user0->nacimiento = $request->get('nacimiento');
        $user0->password = bcrypt($request->get('password'));

        $user0->update();

        return redirect()->route('user')
                        ->with('success','¡Se han actualizado sus datos!');
     //  return view('users.index')->with('success', '¡Se han actualizado sus datos!');
    }

    public function delete()
    {
        return view('users.delete');
    }

    // public function deleted(Request $request)
    // {

    //     return view('users.delete');
    // }

}
