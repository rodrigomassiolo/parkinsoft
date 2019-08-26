<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Auth\RegisterController;
use App\Rol;


class AbmUserController extends Controller
{
    public function index(Request $request)
    {

        $params = $request->except('_token');

        session()->flashInput($request->input());

        $user = User::filter($params)->whereHas('rol',function($q){
            $q->where('type','<>',3);
        })->paginate(10);

         return view('abmUser.index',compact('user'))
             ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('abmUser.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'dni' =>  array(
                'required',
                'regex:/^[0-9]+$/',
                'max:8'
            ),
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'genero' => 'required|string|max:1',
            'nacimiento' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);


        $make1 = \mb_substr($request['nombre'],0,2);
        $make2 = \mb_substr($request['apellido'],0,2);
        $make3 = substr($request['dni'],-3);

        $fill = $make1 . $make2 . $make3;

        $rol = Rol::create([
            'type' => 2,
            'medico_id' => null
        ]);

        User::create([
            'usuario' => $fill,
            'genero' => $request['genero'],
            'nacimiento' => $request['nacimiento'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'rol_id' => $rol['id'],
            'status' => 'A'
        ]);

        return redirect()->route('abmUser.index')
                        ->with('success','Paciente creado correctamente.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('abmUser.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('abmUser.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'genero' => 'required|string|max:1',
            'nacimiento' => 'required|date',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);

        $user->update($request->all());
  
        return redirect()->route('abmUser.index')
                        ->with('success','Usuario actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id',$id)->first();

        $rol = Rol::where('id', $user['rol_id'])->first();;

        $user->usuario = '';
        $user->email = bcrypt($user->email);
        $user->password = '';
        $user->status = 'D';

        $rol->type = 3;

        $rol->update();
        $user->update();
        
        return redirect()->route('abmUser.index')
                           ->with('success','Usuario eliminado correctamente');
    }
}
