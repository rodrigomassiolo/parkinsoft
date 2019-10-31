<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\PacienteEjercicio;


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

        $request->validate([
            'genero' => 'required|string|max:1',
            'nacimiento' => 'required|date',
            'password' => 'required|string|min:8|max:16|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
            'medicamento' => 'required|string|max:50',
            'idioma' => 'required|string|max:15'
        ]);


        $user0->genero = $request->get('genero');
        $user0->nacimiento = $request->get('nacimiento');
        $user0->password = bcrypt($request->get('password'));
        $user0->idioma = $request->get('idioma');
        $user0->medicamento = $request->get('medicamento');

        $user0->update();

        return redirect()->route('user')
                        ->with('success','¡Se han actualizado sus datos!');
    }

    public function delete()
    {
        return view('users.delete');
    }

    public function historial(){

        $user = Auth::user()->usuario;

        $params = array('usuario' => $user);

        $PacienteEjercicio = PacienteEjercicio::filter($params);


        return view('users.historial',compact('PacienteEjercicio'));
    }

}
